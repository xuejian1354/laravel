<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Globalval extends Model
{
    protected $table = 'globalvals';

    protected $fillable = ['name', 'val'];
    
    public static function getVal($name)
    {
    	return Globalval::where('name', $name)->get()[0]->val;
    }
}
