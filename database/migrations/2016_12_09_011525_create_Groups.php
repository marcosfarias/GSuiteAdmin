<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('groups', function (Blueprint $table) {
			$table->increments('id')->unique();
			//
			// 
			$table->string('name');
			//
			//
			$table->string('email');
			//
			// 
			$table->string('description');
			//
			//
			$table->integer('directMembersCount');
			//
			//
			$table->boolean('adminCreated');
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
		Schema::drop('groups');
	}
}
