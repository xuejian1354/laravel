<?php namespace App\Http\Controllers\Home;

use DB,Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminUserFunc;

class HomeController extends Controller {

	protected $grades;

	public function __construct()
	{
		$this->middleware('auth');
		$this->setGrades([Auth::user()->grade]);
	}

	public function setGrades($s = [1])
	{
		$this->grades = $s;
	}

	public function news()
	{
	    $actcontent = (new AdminUserFunc())->getUserActivity();

		return $this->getUserView('home.news')
						->withTitle('news')
						->withUser(Auth::user())
						->withGlobalvals(Controller::getGlobalvals())
						->withRecvnewspagetag($actcontent->recvnewspagetag)
						->withSendnewspagetag($actcontent->sendnewspagetag)
						->withNews($actcontent->news);
	}

	public function tactive()
	{
		if(Auth::user()->grade > 2)
		{
			return view('errors.permitts');
		}

		return $this->getUserView('home.tactive')
						->withTitle('tactive')
						->withGlobalvals(Controller::getGlobalvals());
	}

	public function sactive()
	{
		if(Auth::user()->grade != 1 && Auth::user()->grade != 3)
		{
			return view('errors.permitts');
		}

		return $this->getUserView('home.sactive')
						->withTitle('sactive')
						->withGlobalvals(Controller::getGlobalvals());
	}

}
