<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Redirect;
use App\CloudAccountsStat;
use App\CloudAccount;
use App\GSuiteConnectionConfig;

class CloudAccountsStatsController extends Controller
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
		$cloudAccountsStats = CloudAccountsStat::orderBy('id', 'DESC')->get();
		
		return view('cloudAccountsStats.list',[ 'cloudAccountsStats' => $cloudAccountsStats]);
	}
	
	public function sync() {
		$cloudAccountsStat = new CloudAccountsStat();
		
		$cloudAccountsStat = $cloudAccountsStat->create();

		$suspendedAccountQty = 0;
		$activeAccountQty = 0;
		
		//
		$service = new \Google_Service_Directory(GSuiteConnectionConfig::getClientToGoogleCloud());
		
		$optParams = array('domain' => 'marcosfarias.com', 'maxResults' => '100');
		
		$results = $service->users->listUsers($optParams);
		
		
		//
		$qtyCloudActive = 0;
		$qtyCloudSuspended = 0;
		$qtyCloudMissing = 0;
		$qtyLocallyActive = 0;
		$qtyLocallySuspended = 0;
		$qtyLocallyMissing = 0;
		$qtyDivergenceActive = 0;
		$qtyDivergenceSuspended = 0;
		
		//
		foreach ($results->getUsers() as $user) {
			//
			$cloudAccount = new CloudAccount();
			$cloudAccount->cloud_accounts_stats_id = $cloudAccountsStat->id;
			$cloudAccount->first_name = $user->getName()->getGivenName();
			$cloudAccount->last_name = $user->getName()->getFamilyName();
			$cloudAccount->account_address = $user->getPrimaryEmail();
			//$cloudAccount->password = $user->getPassword();
			

			// cloud_status: 'A' = Active; 'S' = 'Suspended'; 'M' = 'Missing'
			if ($user->getSuspended()) {
				$cloudAccount->cloud_status = 'S';
				$qtyCloudSuspended += 1;				
			} else {
				$cloudAccount->cloud_status = 'A';
				$qtyCloudActive += 1;
			}
			
			// local_status: 'A' = Active; 'S' = 'Suspended'; 'M' = 'Missing'

			$localAccounts = DB::table('accounts')
							->where('account_address', '=', $user->getPrimaryEmail())
							->get();
			//
			if($localAccounts === null || count($localAccounts) == 0) {
				$qtyLocallyMissing += 1;
				$cloudAccount->local_status = 'M';
				$cloudAccount->status = 'P';
			} else {
				foreach ($localAccounts as $localAccount)
				{
					$cloudAccount->local_status = 'A';
					$qtyLocallyActive++;
					$cloudAccount->status = CloudAccountsStatsController::compareCloudLocalData($cloudAccount, $localAccount);
					//
				}
			}
			//
			if ($cloudAccount->status == 'P') {
				if ($cloudAccount->cloud_status === 'A' || $cloudAccount->local_status === 'A') {
					$qtyDivergenceActive++;
				} 
// 				else {
// 					$qtyDivergenceSuspended++;
// 				}
			}
							
			//
			$cloudAccount->save();
		}
		
		$cloudAccountsStat->qty_cloud_active = $qtyCloudActive;
		$cloudAccountsStat->qty_cloud_suspended = $qtyCloudSuspended;
		//$cloudAccountsStat->qty_cloud_active = $qtyCloudMissing;
		$cloudAccountsStat->qty_locally_active = $qtyLocallyActive;
		$cloudAccountsStat->qty_locally_suspended = $qtyLocallySuspended;
		//$cloudAccountsStat->qty_cloud_active = $qtyLocallyMissing;
		$cloudAccountsStat->qty_divergence_active = $qtyDivergenceActive;
		$cloudAccountsStat->qty_divergence_suspended = $qtyDivergenceSuspended ;
		
		$cloudAccountsStat->save();
		
		return Redirect::to('cloudAccountsStats');
	}
	
	/**
	 * 
	 * @param unknown $cloudAccount
	 * @param unknown $localAccount
	 */
	public function compareCloudLocalData($cloudAccount, $localAccount) {
		//
		if ($localAccount === null || $cloudAccount === null ) {
			return 'P';
		}
		//
		if (	
				(strcasecmp($cloudAccount->first_name, $localAccount->first_name) == 0
			&& 	strcasecmp($cloudAccount->last_name, $localAccount->last_name) == 0
			//&& 	strcasecmp($cloudAccount->cloud_status, $localAccount->locally_status) == 0 
				)
			) {
				return 'OK';
			}
			else {
				return 'P'; 	
			}
	}
	
}
