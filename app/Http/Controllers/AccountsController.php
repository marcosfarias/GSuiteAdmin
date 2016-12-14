<?php

namespace App\Http\Controllers;


use App\Account;
use App\GSuiteConnectionConfig;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect;

class AccountsController extends Controller
{

	/**
	 * Este método restringe o acesso à usuários autenticados.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	
// 	public function index() {

// 		$service = new \Google_Service_Directory(GSuiteConnectionConfig::getClientToGoogleCloud());
		
// 		$optParams = array('domain' => 'marcosfarias.com', 'maxResults' => '100');

// 		$results = $service->users->listUsers($optParams);
		
// 		foreach ($results->getUsers() as $user) {
// 			printf("<br/>%s (%s) %s\n", $user->getPrimaryEmail(),
// 					$user->getName()->getFullName(),$user->getPassword());
// 		}
		
// 	}

	/**
	 * 
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function index() {
		$accounts = Account::get();
	
		return view('accounts.list',[ 'accounts' => $accounts ]);
	}
	
	/**
	 * 
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function add() {
		//
		return view('accounts.form');
	}
	
	/**
	 * A user account can be added to any of your Google Apps account's domains, including the account's primary domain. 
	 * And before adding a user account, confirm the domain ownership.
	 * 
	 * If you upgraded your personal Gmail account to a business email account with your own domain name, you won’t be able create new user accounts until you unlock additional Google Apps for Work settings. 
	 * For details, see Create business emails for your team.
	 * 
	 * To create a user account using one of your domains, use the following POST request and include the authorization described in Authorize requests. 
	 * For the request query string properties, see the API Reference.
	 * 	POST https://www.googleapis.com/admin/directory/v1/users
	 * All create requests require you to submit the information needed to fulfill the request. If you are using client libraries, they convert the data objects from your chosen language into JSON data formatted objects.
	 * 
	 * @see https://developers.google.com/admin-sdk/directory/v1/guides/manage-users#create_user
	 * @param Request $request
	 * @return unknown
	 */
	public function save(Request $request) {
		//
		DB::beginTransaction();
		//
		try {
			//
			$account = new Account();
			//
			$account = $account->create($request->all());
			
			//
			// --------------------------------------------------------------------------------------------------------
			// Instancia objeto do tipo Google_Service_Directory usando objeto $client retornado por GSuiteConnectionConfig::getClientToGoogleCloud() 
			$service = new \Google_Service_Directory(GSuiteConnectionConfig::getClientToGoogleCloud());
			//
			$nameInstance = new \Google_Service_Directory_UserName();
			$nameInstance -> setGivenName($account->first_name);
			$nameInstance -> setFamilyName($account->last_name);
			//
			$userInstance = new \Google_Service_Directory_User();
			$userInstance -> setName($nameInstance);
			$userInstance -> setHashFunction("MD5");
			$userInstance -> setPrimaryEmail($account->account_address);
			$userInstance -> setPassword(hash("md5", $account->password));
			//
			$createUserResult = $service->users->insert($userInstance);

			//
			// --------------------------------------------------------------------------------------------------------
			//
			DB::commit();
			//
			\Session::flash('success_message', 'Nova Conta cadastrada com sucesso!');
			//
		}
		catch (Google_IO_Exception $gioe)
		{
			DB::rollback();
			echo "Error in connection: ".$gioe->getMessage();
			\Session::flash('fail_message', "Error in connection: ".$gioe->getMessage());
		}
		catch (Google_Service_Exception $gse)
		{
			DB::rollback();
			echo "Error in connection: ".$gse->getMessage();
			\Session::flash('fail_message', "User already exists: ".$gse->getMessage());
		} catch (\Exception $e) {
			DB::rollback();
			echo "Error in connection: ".$e->getMessage();
			\Session::flash('fail_message', $e->getMessage());
		}
		//	
		return Redirect::to('accounts/'.$account->id.'/edit');
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function edit($id) {
		// var_dump($id);
		$account = Account::findOrFail($id);
	
		return view('accounts.form', ['account' => $account]);
	}
	
	/**
	 * The userKey can be the user's primary email address, the unique user id, or one of the user's alias email addresses. 
	 * @see https://developers.google.com/admin-sdk/directory/v1/guides/manage-users#update_user
	 * @param unknown $id
	 * @param Request $request
	 * @return unknown
	 */
	public function update($id, Request $request) {
		//
		DB::beginTransaction();
		//
		try {
			//
			$account = Account::findOrFail($id);
			//
			$currentAccountAddress = $account->account_address;
			//
			$account->update($request->all());
		
			//
			// --------------------------------------------------------------------------------------------------------
			// Instancia objeto do tipo Google_Service_Directory usando objeto $client retornado por GSuiteConnectionConfig::getClientToGoogleCloud() 
			$service = new \Google_Service_Directory(GSuiteConnectionConfig::getClientToGoogleCloud());
			
			// Executa consulta usando $service para obter do Google uma instância do objeto user que se deseja atualizar
			// Interessante observar que a chave da busca pode ser o endereço principal ou um dos alias/nicknames do usuário
			$user = $service->users->get($currentAccountAddress);

			// Atualiza atributos Nome e Sobrenome com os novos valores
			$nameInstance = new \Google_Service_Directory_UserName();
			$nameInstance -> setGivenName($account->first_name);
			$nameInstance -> setFamilyName($account->last_name);
			
			// Atualiza atributos Nome, E-mail e Senha com os novos valores
			$user -> setName($nameInstance);
			$user -> setHashFunction("MD5");
			$user -> setPrimaryEmail($account->account_address);
			$user -> setPassword(hash("md5", $account->password));
			
			// Executa atualização do usuário no Google usando $service e armazena resultado em $updateUserResult
			$updateUserResult = $service->users->update($currentAccountAddress, $user);
			//var_dump($updateUserResult);
			//
			// --------------------------------------------------------------------------------------------------------
			//
			DB::commit();
			//
			\Session::flash('success_message', 'Conta atualizada com sucesso!');
			//
		} catch (Google_IO_Exception $gioe) {
			DB::rollback();
			\Session::flash('fail_message', $gioe->getMessage());
			echo $gioe->getMessage();
		} catch (Google_Service_Exception $gse) {
			DB::rollback();
			\Session::flash('fail_message', $gse->getMessage());
			echo $gse->getMessage();
		} catch (\Exception $e) {
			DB::rollback();
			\Session::flash('fail_message', $e->getMessage());
			echo $e->getMessage();
		}
		//
		return Redirect::to('accounts/'.$account->id.'/edit');
	}
	
	/**
	 * The userKey can be the user's primary email address, the unique user id, or one of the user's alias email addresses.
	 * Important things to consider before deleting a user:
	 *  - The deleted user will no longer be able to log in.
	 *  - For more information about user account deletion, please refer to the administration help center at http://support.google.com/a/bin/answer.py?answer=33314
	 * @see https://developers.google.com/admin-sdk/directory/v1/guides/manage-users#delete_user
	 * @param $id
	 * @return unknown
	 */
	public function delete($id) {
		//
		DB::beginTransaction();
		//
		try {
			//
			$account = Account::findOrFail($id);
			//
			$userKey = $account->account_address;
			//
			$account->delete();
			//
			// --------------------------------------------------------------------------------------------------------
			//
			$service = new \Google_Service_Directory(GSuiteConnectionConfig::getClientToGoogleCloud());
			
			// Executa exclusão do usuário no Google usando $service e armazena resultado em $deleteUserResult
			$deleteUserResult = $service->users->delete($userKey);
			//var_dump($deleteUserResult);
			//
			// --------------------------------------------------------------------------------------------------------
			//
			DB::commit();
			//
			\Session::flash('success_message', 'Conta excluída com sucesso!');
			//
		} catch (Google_IO_Exception $gioe) {
			DB::rollback();
			\Session::flash('fail_message', $gioe->getMessage());
			echo $gioe->getMessage();
		} catch (Google_Service_Exception $gse) {
			DB::rollback();
			\Session::flash('fail_message', $gse->getMessage());
			echo $gse->getMessage();
		} catch (\Exception $e) {
			DB::rollback();
			\Session::flash('fail_message', $e->getMessage());
			echo $e->getMessage();
		}
		//
		return Redirect::to('accounts/');
	}
	

	
}