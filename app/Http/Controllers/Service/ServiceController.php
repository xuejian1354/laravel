<?php namespace App\Http\Controllers\Service;

use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class ServiceController extends Controller {

	protected $grades = [1, 2, 3];

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return $this->getUserView('service.service')->withGlobalvals(Controller::getGlobalvals());
	}

}
