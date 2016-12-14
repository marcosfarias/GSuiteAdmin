<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CloudAccountsController extends Controller
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
	 * @param unknown $id
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function index($id) {

		$cloudAccountsStats =  DB::table('cloud_accounts_stats')
								->where('id', '=', $id)
								->get();
		
		$cloudAccounts = DB::table('cloud_accounts')
							->where('cloud_accounts_stats_id', '=', $id)
							->get();
		
	
		return view('cloudAccounts.list',[ 'cloudAccountsStats' => $cloudAccountsStats, 'cloudAccounts' => $cloudAccounts]);
	}

}
