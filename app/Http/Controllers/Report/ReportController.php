<?php namespace App\Http\Controllers\Report;

use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class ReportController extends Controller {

	protected $grades = [1, 2, 3];

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function check()
	{
		return $this->getUserView('report.check')
						->withTitle('check')
						->withGlobalvals(Controller::getGlobalvals());
	}

	public function work()
	{
		return $this->getUserView('report.work')
						->withTitle('work')
						->withGlobalvals(Controller::getGlobalvals());
	}

}
