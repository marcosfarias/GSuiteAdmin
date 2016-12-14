<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCloudAccountsStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('cloud_accounts_stats', function (Blueprint $table) {
			$table->increments('id')->unique();
			$table->integer('qty_cloud_active');
			$table->integer('qty_cloud_suspended');
			$table->integer('qty_locally_active');
			$table->integer('qty_locally_suspended');
			$table->integer('qty_divergence_active');
			$table->integer('qty_divergence_suspended');
			$table->rememberToken();
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
		Schema::drop('cloud_accounts_stats');
	}
}
