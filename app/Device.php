<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public function rel_type() {
    	return $this->hasOne('App\Devtype', 'id', 'type');
	}

	public function rel_owner() {
		return $this->hasOne('App\User', 'owner', 'sn');
	}
}
