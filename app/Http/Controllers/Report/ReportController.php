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

	public function index()
	{
		return $this->getUserView('report.report')->withGlobalvals(Controller::getGlobalvals());
	}

}
