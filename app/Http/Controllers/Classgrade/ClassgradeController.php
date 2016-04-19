<?php namespace App\Http\Controllers\Classgrade;

use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class ClassgradeController extends Controller {

	protected $grades = [1, 3];

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function info()
	{
		return $this->getUserView('classgrade.info')
						->withTitle('info')
						->withGlobalvals(Controller::getGlobalvals());
	}

	public function details()
	{
		return $this->getUserView('classgrade.details')
						->withTitle('details')
						->withGlobalvals(Controller::getGlobalvals());
	}

}
