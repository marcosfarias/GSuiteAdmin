<?php

/*
 |--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'web'], function() {

	//----------------------------------------------------------------
	// Rotas "Iniciais"
	//
	Route::get('/', 'HomeController@index');
	Route::auth();
	Route::get('home', 'HomeController@index');

	//----------------------------------------------------------------
	// Rotas relacionadas a gestão das confis de conexão com o G Suite
	//
	Route::get('gSuiteConnectionConfig','GSuiteConnectionConfigController@index');
	Route::post('gSuiteConnectionConfig/save','GSuiteConnectionConfigController@save');
	Route::get('gSuiteConnectionConfig/{id}/edit','GSuiteConnectionConfigController@edit');
	Route::patch('gSuiteConnectionConfig/{config}','GSuiteConnectionConfigController@update');
	
	
	//----------------------------------------------------------------
	// Rotas relacionadas a gestão de Usuários
	//
	Route::get('accounts','AccountsController@index');
	Route::get('accounts/add','AccountsController@add');
	Route::get('accounts/{id}/edit','AccountsController@edit');
	Route::post('accounts/save','AccountsController@save');
	Route::patch('accounts/{account}','AccountsController@update');
	Route::delete('accounts/{account}','AccountsController@delete');
	
	//----------------------------------------------------------------
	// Rotas relacionadas a gestão de Grupos
	//
	Route::get('groups','GroupsController@index');
	Route::get('groups','GroupsController@index');
	Route::get('groups/add','GroupsController@add');
	Route::get('groups/{id}/edit','GroupsController@edit');
	Route::post('groups/save','GroupsController@save');
	Route::patch('groups/{account}','GroupsController@update');
	Route::delete('groups/{account}','GroupsController@delete');
	
	//----------------------------------------------------------------
	// Rotas relacionadas a gestão de Membros dos Grupos
	//
	Route::get('groups/{id}/members','GroupsMembersController@index');
	Route::get('groups/{id}/members/add','GroupsMembersController@add');
	Route::post('groups/{id}/members/save','GroupsMembersController@save');
	Route::get('groups/{id}/members/{groupMemberId}/edit','GroupsMembersController@edit');
	Route::patch('groups/{id}/members/{groupMemberId}/update','GroupsMembersController@update');
	Route::delete('groups/{id}/members/{groupMemberId}/remove','GroupsMembersController@delete');
	
	//----------------------------------------------------------------
	// MISC
	//
	Route::get('cloudAccountsStats','CloudAccountsStatsController@index');
	Route::get('cloudAccountsStats/sync','CloudAccountsStatsController@sync');
	Route::get('cloudAccounts/{id}','CloudAccountsController@index');
	
});
