<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
	protected $fillable = [
			'first_name',
			'last_name',
			'account_address',
			'password',
			'source_id'
	];
	
}
