<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Areabox extends Model
{
	public function rel_contents() {
		return $this->hasMany('App\Areaboxcontent', 'box_id', 'id');
	}
}
