<?php namespace App\Http\Controllers\Course;

use DB, Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class CourseController extends Controller {

	protected $grades = [1, 2, 3];

	public function __construct()
	{
		$this->middleware('auth');
	}
	
	public function index()
	{
	    if(Auth::user()->grade == 1)
	    {
	        return $this->arrange();
	    }

	    return $this->query();
	}

	public function query()
	{
		return $this->getUserView('course.query')
						->withTitle('query')
						->withGlobalvals(Controller::getGlobalvals());
	}

	public function arrange()
	{
	    return $this->getUserView('course.arrange')
                	    ->withTitle('arrange')
                	    ->withGlobalvals(Controller::getGlobalvals());
	}

	public function exam()
	{
	    return $this->getUserView('course.exam')
                	    ->withTitle('exam')
                	    ->withGlobalvals(Controller::getGlobalvals());
	}

	public function choice()
	{
	    return $this->getUserView('course.choice')
                	    ->withTitle('choice')
                	    ->withGlobalvals(Controller::getGlobalvals());
	}

	public function score()
	{
	    return $this->getUserView('course.score')
                	    ->withTitle('score')
                	    ->withGlobalvals(Controller::getGlobalvals());
	}
}
