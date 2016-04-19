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

	public function info()
	{
		return $this->getUserView('academy.info')
						->withTitle('info')
						->withGlobalvals(Controller::getGlobalvals());
	}
	
	public function team()
	{
		return $this->getUserView('academy.team')
						->withTitle('team')
						->withGlobalvals(Controller::getGlobalvals());
	}

}
