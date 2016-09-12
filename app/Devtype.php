<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devtype extends Model
{
    public function rel_attr() {
    	return $this->hasOne('App\Devattr', 'id', 'attr');
    }
}
