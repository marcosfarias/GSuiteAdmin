<?php

namespace App\Http\Controllers;

use App\Group;
use App\GSuiteConnectionConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect;

class GroupsController extends Controller
{

	/**
	 * Este método restringe o acesso desta classe somente à usuários autenticados.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
	 * 
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function index() {
		//
		$groups = Group::get();
		//
		return view('groups.list',[ 'groups' => $groups ]);
	}
	
	/**
	 * 
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function add() {
		//
		return view('groups.form');
	}
	
	/**
	 * A group can be created for any domain associated with the account.
	 * @see https://developers.google.com/admin-sdk/directory/v1/guides/manage-groups#create_group
	 * @param Request $request
	 * @return unknown
	 */
	public function save(Request $request) {
		//
		DB::beginTransaction();
		//
		try {
			//
			$group = new Group();
			//
			$group = $group->create($request->all());
			//
			// --------------------------------------------------------------------------------------------------------
			//
			$service = new \Google_Service_Directory(GSuiteConnectionConfig::getClientToGoogleCloud());
			//
			$googleGroup = new \Google_Service_Directory_Group();
			$googleGroup -> setName($group->name);
			$googleGroup -> setEmail($group->email);
			$googleGroup -> setDescription($group->description);
			//
			$service->groups->insert($googleGroup);
			//
			// --------------------------------------------------------------------------------------------------------
			//
			DB::commit();
			//
			return Redirect::to('groups/'.$group->id.'/edit')->with('success_message', 'Novo Grupo cadastrado com sucesso!');
			//
		} catch (Google_IO_Exception $gioe) {
			DB::rollback();
			$fail_message = $gioe->getMessage();
		} catch (Google_Service_Exception $gse) {
			DB::rollback();
			$fail_message = $gse->getMessage();
		} catch (\Exception $e) {
			DB::rollback();
			$fail_message = $e->getMessage();
		}
		//
		return redirect()->back()->with('fail_message', [$fail_message]);
		//return Redirect::to('groups/'.$group->id.'/edit')->with('fail_message', $fail_message);
	}
	

	/**
	 * 
	 * @param unknown $id
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function edit($id) {
		//
		$group = Group::findOrFail($id);
		//
		return view('groups.form', ['group' => $group]);
	}
	
	/**
	 * The groupKey is the group's email address, any of the group alias's email address, or the group's unique id. 
	 * In general, Google recommends to not use the group's email address as a key for persistent data since the email address is subject to change.
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
			$group = Group::findOrFail($id);
			//
			// Obtém a chave atual do grupo antes do registro ser modificado com os valores informados pelo usuário
			$currentGroupKey = $group->email;
			//
			// atualiza objeto do BD com os dados do request
			$group->update($request->all());
			//
			// --------------------------------------------------------------------------------------------------------
			//
			$service = new \Google_Service_Directory(GSuiteConnectionConfig::getClientToGoogleCloud());
			//
			$googleGroup = $service->groups->get($currentGroupKey);
			//
			$googleGroup -> setName($group->name);
			$googleGroup -> setEmail($group->email);
			$googleGroup -> setDescription($group->description);
			//			
			$service->groups->update($currentGroupKey, $googleGroup);
			//
			// --------------------------------------------------------------------------------------------------------
			//
			DB::commit();
			//
			\Session::flash('success_message', 'Grupo atualizado com sucesso!');
			//
		} catch (Google_IO_Exception $gioe) {
			DB::rollback();
			\Session::flash('fail_message', $gioe->getMessage());
			echo "Erro ".$gioe->getMessage();
		} catch (Google_Service_Exception $gse) {
			DB::rollback();
			\Session::flash('fail_message', $gse->getMessage());
			echo "Erro ".$gse->getMessage();
			} catch (\Exception $e) {
			DB::rollback();
			\Session::flash('fail_message', $e->getMessage());
			echo "Erro ".$e->getMessage();
		}
		//
		return Redirect::to('groups/'.$group->id.'/edit');
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @return unknown
	 */
	public function delete($id) {
		//
		DB::beginTransaction();
		//
		try {
			//
			$group = Group::findOrFail($id);
			//
			$groupKey = $group->email;
			//
			// --------------------------------------------------------------------------------------------------------
			//
			$service = new \Google_Service_Directory(GSuiteConnectionConfig::getClientToGoogleCloud());
			//
			$service->groups->delete($groupKey);
			//
			// --------------------------------------------------------------------------------------------------------
			//
			$group->delete();
			//
			DB::commit();
			//
			\Session::flash('success_message', 'Grupo excluído com sucesso!');
			//
		} catch (Google_IO_Exception $gioe) {
			DB::rollback();
			\Session::flash('fail_message', $gioe->getMessage());
		} catch (Google_Service_Exception $gse) {
			DB::rollback();
			\Session::flash('fail_message', $gse->getMessage());
		} catch (\Exception $e) {
			DB::rollback();
			\Session::flash('fail_message', $e->getMessage());
		}
		//
		// --------------------------------------------------------------------------------------------------------
		//
		return Redirect::to('groups/');
	}
}
