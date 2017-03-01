<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Areabox extends Model
{
	public function rel_contents() {
		return $this->hasMany('App\Model\Areaboxcontent', 'box_id', 'id');
	}
}
