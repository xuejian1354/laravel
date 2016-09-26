<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alarminfo extends Model
{
    protected $fillable = ['sn', 'content', 'devsn', 'action', 'thres', 'val', 'optnum', 'enable'];

    public function rel_devname() {
    	return $this->hasOne('App\Device', 'sn', 'devsn');
    }
}
