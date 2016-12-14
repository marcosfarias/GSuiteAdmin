<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCloudAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('cloud_accounts', function (Blueprint $table) {
    		$table->increments('id')->unique();
    		$table->integer('cloud_accounts_stats_id')->unsigned();
    		$table->string('first_name');
    		$table->string('last_name');
    		$table->string('account_address');
    		$table->string('password');
    		// 'A' = Active; 'S' = 'Suspended'; 'M' = 'Missing'
    		$table->string('cloud_status',1);
    		// 'A' = Active; 'S' = 'Suspended'; 'M' = 'Missing'
    		$table->string('local_status',1);
    		$table->string('action',100);
    		// 'OK' = Synced; 'P' = Pending
    		$table->string('status',2);
    		$table->unique(['cloud_accounts_stats_id', 'account_address']);
    		$table->rememberToken();
    		$table->timestamps(); // timestamps automaticamente cria 2 campos: created_at e updated_at :-)
    	});
    	
    		Schema::table('cloud_accounts', function (Blueprint $table) {
    			$table->foreign('cloud_accounts_stats_id')->references('id')->on('cloud_accounts_stats');
    		});
    			 
    			 
    	
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::drop('cloud_accounts');
    }
}
