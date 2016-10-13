<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
	protected $fillable = ['sn', 'name', 'type', 'attr', 'data', 'area', 'owner'];

    public function rel_type() {
    	return $this->hasOne('App\Devtype', 'id', 'type');
	}

	public function rel_owner() {
		return $this->hasOne('App\User', 'sn', 'owner');
	}

	public function rel_area() {
		return $this->hasOne('App\Area', 'sn', 'area');
	}
}
