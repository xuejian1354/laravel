<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Globalval extends Model
{
    protected $table = 'globalvals';

    protected $fillable = ['name', 'val'];
    
    public static function getVal($name)
    {
    	try {
	    	$agloval = Globalval::where('name', $name)->first();
	    	return $agloval? $agloval->val : NULL;
    	} catch (\PDOException $e) {
    		return NULL;
    	}
    }
}
