<?php namespace App\Http\Controllers\Classroom;

use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class ClassroomController extends Controller {

	protected $grades = [1, 2, 3];

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function status()
	{
		return $this->getUserView('classroom.status')
						->withTitle('status')
						->withGlobalvals(Controller::getGlobalvals());
	}

	public function opt()
	{
		return $this->getUserView('classroom.opt')
						->withTitle('opt')
						->withGlobalvals(Controller::getGlobalvals());
	}

}
