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

	public function index()
	{
		return $this->getUserView('classgrade.classgrade')->withGlobalvals(Controller::getGlobalvals());
	}

}
