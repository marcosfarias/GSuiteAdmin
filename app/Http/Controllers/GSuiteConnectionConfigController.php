<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\GSuiteConnectionConfig;
use Illuminate\Support\Facades\Redirect;

class GSuiteConnectionConfigController extends Controller
{
	public $CONFIG_ID = 1;
	
	public function index() {
		//
		try {
			$config = GSuiteConnectionConfig::find($this->CONFIG_ID);
		} catch (QueryException $e) {
			
		}
		
		if ($config) {
			return Redirect::to('gSuiteConnectionConfig/'.$config->id.'/edit');
			//return view('gSuiteConnectionConfig.form', ['config' => $config]);
		} else {
			return view('gSuiteConnectionConfig.form');
		}
	}	
	
	public function edit($id) {
	
		// var_dump($id);
		$config = GSuiteConnectionConfig::findOrFail($this->CONFIG_ID);
	
		return view('gSuiteConnectionConfig.form', ['config' => $config]);
	}
	
	public function save(Request $request) {
		
		$config = new GSuiteConnectionConfig();
		
		$config = $config->create($request->all());
			
		\Session::flash('success_message', 'Config inserida com sucesso!');
		
		return Redirect::to('gSuiteConnectionConfig/');
		
	}
	
	public function update($id, Request $request) {
		$config = GSuiteConnectionConfig::findOrFail($this->CONFIG_ID);
	
		$config->update($request->all());
	
		///
		//
		// --------------------------------------------------------------------------------------------------------
		//
	
		\Session::flash('success_message', 'Config atualizada com sucesso!');
	
		return Redirect::to('gSuiteConnectionConfig/'.$config->id.'/edit');
	}
	
}
