<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\View\Factory as ViewFactory;

use App\Model\DBStatic\Globalval;
use App\Model\DBStatic\Devtype;
use App\Model\DBStatic\Devcmd;
use App\Http\Controllers\Academy\AcademyController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function getGrades()
	{
		return $this->grades;
	}

    public static function getGlobalvals()
    {
    	$dbvals = Globalval::all();
    	$globalvals = array();
    	foreach ($dbvals as $dbval)
    	{
    		$globalvals[$dbval->name] = $dbval->fieldval;
    	}

    	return $globalvals;
    }
    
    public static function updateGlobalval($name, $val)
    {
        $gloval = Globalval::where('name', '=', $name)->get();
        if($gloval->count() > 0)
        {
            $gloval = $gloval[0];
            $gloval->fieldval = $val;
            $gloval->save();
        }
        else
        {
            Globalval::create([
                'name' => $name,
                'fieldval' => $val,
            ]);
        }
    }

    public static function getDevCmds()
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
    				goto next;
    			}
    		}
    		$devcmd['index'] = 0;
    		next: ;
    	}

    	return $devcmds;
    }

    public function getUserView($view = null, $data = [], $mergeData = [])
    {
		$isMatch = false;
		foreach ($this->getGrades() as $grade)
		{
			if($grade == Auth::user()->grade)
			{
				$isMatch = true;
				break;
			}
		}

		if($isMatch == false)
		{
			return view('errors.permitts');
		}

		return view($view, $data, $mergeData);
	}
}
