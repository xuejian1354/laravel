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

	public function email()
	{
		return $this->getUserView('service.email')
						->withTitle('email')
						->withGlobalvals(Controller::getGlobalvals());
	}

	public function file()
	{
		return $this->getUserView('service.file')
						->withTitle('file')
						->withGlobalvals(Controller::getGlobalvals());
	}
	
	public function note()
	{
		return $this->getUserView('service.note')
						->withTitle('note')
						->withGlobalvals(Controller::getGlobalvals());
	}

}
