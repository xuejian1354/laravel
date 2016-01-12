<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Model\DBStatic\Globalval;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function getGlobalvals()
    {
    	$dbvals = Globalval::all();
    	$globalvals = array();
    	foreach ($dbvals as $dbval)
    	{
    		$globalvals[$dbval->key] = $dbval->val;
    	}
    	
    	return $globalvals;
    }
}
