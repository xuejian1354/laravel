<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public function rel_action() {
    	return $this->hasOne('App\Action', 'id', 'action');
    }
}
