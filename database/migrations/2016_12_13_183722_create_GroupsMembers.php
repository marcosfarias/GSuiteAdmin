<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsMembers extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_members', function (Blueprint $table) {
			$table->increments('id')->unique();
			//
			// Id of the group to which this member will belong
			$table->integer('group_id');
			//
			// Member account address, ie: marcos@yourdomain.com
			$table->string('email');
			//
			// Role of the member: could be OWNER, MANAGER or MEMBER 
			$table->string('role');
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
		Schema::drop('group_members');
	}
}
