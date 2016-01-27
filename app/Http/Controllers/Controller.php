<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Model\DBStatic\Globalval;
use App\Model\DBStatic\Devtype;
use App\Model\DBStatic\Devcmd;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function getGlobalvals()
    {
    	$dbvals = Globalval::all();
    	$globalvals = array();
    	foreach ($dbvals as $dbval)
    	{
    		$globalvals[$dbval->name] = $dbval->fieldval;
    	}
    	
    	return $globalvals;
    }

    public function getDevCmds()
    {
    	$devcmds = Devcmd::all();
    	$devtypes = Devtype::all();
    	foreach ($devtypes as $devtype)
    	{
    		$devtype['count'] = 0;
    	}

    	foreach ($devcmds as $devcmd)
    	{
    		foreach ($devtypes as $devtype)
    		{
    			if($devtype->devtype == $devcmd->dev_type)
    			{
    				$devtype['count'] += 1;
    				$devcmd['index'] = $devtype['count'];
    			}
    		}
    	}

    	return $devcmds;
    }
}
