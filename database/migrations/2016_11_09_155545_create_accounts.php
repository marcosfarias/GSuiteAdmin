<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('accounts', function (Blueprint $table) {
    		$table->increments('id')->unique();
    		$table->string('first_name');
    		$table->string('last_name');
    		$table->string('account_address')->unique();
    		$table->string('password');
    		$table->rememberToken();
    		$table->timestamps(); // timestamps automaticamente cria 2 campos: created_at e updated_at :-)
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::drop('accounts');
    }
}
