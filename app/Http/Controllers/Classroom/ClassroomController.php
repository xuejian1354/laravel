<?php namespace App\Http\Controllers\Classroom;

use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminUserFunc;

class ClassroomController extends Controller {

	protected $grades = [1, 2, 3];

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function status()
	{
	    $actcontent = (new AdminUserFunc())->getUserClassgrade();
		return $this->getUserView('classroom.status')
						->withTitle('status')
						->withActcontent($actcontent)
						->withGlobalvals(Controller::getGlobalvals());
	}

	public function opt()
	{
	    $actcontent = (new AdminUserFunc())->getUserClassgrade();
		return $this->getUserView('classroom.opt')
						->withTitle('opt')
						->withActcontent($actcontent)
						->withGlobalvals(Controller::getGlobalvals());
	}

}
