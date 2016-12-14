<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGSuiteConnectionConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('g_suite_connection_configs', function (Blueprint $table) {
    		$table->increments('id')->unique();
    		//
    		// example: GSuiteAdmin
    		$table->string('application_name');
    		//
    		// username of an admin user who is impersonated by the application, ie: admin@yourdomain.com
    		$table->string('subject'); 
    		//
    		// full path to Credentials JSon file, ie: /Users/marcos-farias/Documents/workspace-php/GSuiteAdmin/service-account-credentials.json
    		$table->string('auth_config_path');
    		//
    		// Comma separated values Scopes used by the application, 
    		// ie: https://www.googleapis.com/auth/admin.directory.user
    		$table->string('scopes',4000);
    		//
    		// timestamps automaticamente cria 2 campos: created_at e updated_at :-)
    		$table->timestamps();
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::drop('g_suite_connection_configs');
    }
}
