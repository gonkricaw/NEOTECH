<?php

namespace App\Models;

use App\Casts\Hash;
use App\Models\BaseModel;

class UserAddress extends BaseModel
{
	protected $table = 'user_address';

	protected $default = ['xid', 'name'];

	protected $filterable = ['name'];

	protected $guarded = ['id'];

	protected $hidden = ['id', 'user_id'];

	protected $appends = ['xid', 'x_user_id'];

	protected $hashableGetterFunctions = [
		'getXUserIdAttribute' => 'user_id'
	];

	protected $casts = [
		'user_id' => Hash::class . ':hash'
	];
}
