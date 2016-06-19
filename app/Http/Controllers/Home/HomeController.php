<?php namespace App\Http\Controllers\Home;

use DB, Auth, Input;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminUserFunc;

class HomeController extends Controller {

	protected $grades;

	public function __construct()
	{
		$this->middleware('auth');
		if(Auth::guest() === false)
		{
		  $this->setGrades([Auth::user()->grade]);
		}
	}

	public function setGrades($s = [1])
	{
		$this->grades = $s;
	}

	public function news()
	{
	    $adminUserFunc = new AdminUserFunc();
	    $actcontent = $adminUserFunc->getUserActivity();
	    $retview = 'home.news';
	    if(Input::get('iscontent') == 1)
	    {
	        $retview = 'admin.useractivity.useractivity';
	    }

        return $this->getUserView($retview)
            	        ->withTitle('news')
            	        ->withActcontent($actcontent)
            	        ->withGlobalvals(Controller::getGlobalvals());
	}

	public function status()
	{
		return $this->getUserView('home.status')
						->withTitle('status')
						->withGlobalvals(Controller::getGlobalvals());
	}

}
