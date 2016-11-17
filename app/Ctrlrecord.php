<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ctrlrecord extends Model
{
	protected $fillable = ['sn', 'content', 'usersn', 'action', 'optnum', 'data'];

    public function rel_action() {
    	return $this->hasOne('App\Action', 'id', 'action');
    }
}
