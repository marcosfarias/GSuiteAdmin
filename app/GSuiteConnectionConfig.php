<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GSuiteConnectionConfig extends Model
{
	
	protected $fillable = [
			'application_name',
			'subject',
			'auth_config_path',
			'scopes'
	];
	
	/**
	 *
	 */
	public static function getClientToGoogleCloud() {
		//
		$CONFIG_ID = 1;
		//
		$config = GSuiteConnectionConfig::findOrFail($CONFIG_ID);
		
		//
		$client = new \Google_Client();
		
		//
		//
		//$client->setApplicationName("GSuiteAdmin");
		$client->setApplicationName($config->application_name);
		
		//
		//$client->setAuthConfig('/Users/mfarias/Documents/workspace-php/GSuiteAdmin/service-account-credentials.json');
		$client->setAuthConfig($config->auth_config_path);
		
		
		//
		//$client->setSubject("admin@marcosfarias.com"); // MARCOS FARIAS
		$client->setSubject($config->subject);
	
		//
		$client->addScope('https://www.googleapis.com/auth/admin.directory.group');
		$client->addScope('https://www.googleapis.com/auth/apps.groups.settings');		
		$client->addScope('https://www.googleapis.com/auth/admin.directory.user');
		$client->addScope('https://www.googleapis.com/auth/admin.directory.orgunit');
		$client->addScope('https://www.googleapis.com/auth/admin.directory.userschema');
		//$client->setScopes($config->scopes);
		
		//
		return $client;
	}
}


