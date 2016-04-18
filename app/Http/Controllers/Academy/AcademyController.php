<?php namespace App\Http\Controllers\Academy;

use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class AcademyController extends Controller {

	protected  $grades = [1, 2];

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return $this->getUserView('academy.academy')->withGlobalvals(Controller::getGlobalvals());
	}

}
