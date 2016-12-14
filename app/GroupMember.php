<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
	protected $fillable = [
			'group_id',
			'email',
			'role'
	];
}
