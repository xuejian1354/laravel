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
		if(Auth::guest() === false)
		{
		  $this->setGrades([Auth::user()->grade]);
		}
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

	public function status()
	{
		return $this->getUserView('home.status')
						->withTitle('status')
						->withGlobalvals(Controller::getGlobalvals());
	}

}
