<?php namespace App\Http\Controllers\Course;

use DB, Auth, Input;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminUserFunc;

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
	    $actcontent = (new AdminUserFunc())->getUserCourse();
		return $this->getUserView('course.query')
						->withTitle('query')
						->withActcontent($actcontent)
						->withGlobalvals(Controller::getGlobalvals());
	}

	public function arrange()
	{
	    $actcontent = (new AdminUserFunc())->getUserCourse();
	    $retview = 'course.arrange';
	    if(Input::get('iscontent') == 1)
	    {
	        $retview = 'admin.usercourse.coursearrange';
	    }

	    if($actcontent->action == 'arrange')
	    {
	        $retview = 'course.arrangeopt';
	    }

	    return $this->getUserView($retview)
                	    ->withTitle('arrange')
                	    ->withActcontent($actcontent)
                	    ->withGlobalvals(Controller::getGlobalvals());
	}

	public function exam()
	{
	    $actcontent = (new AdminUserFunc())->getUserExam();
	    return $this->getUserView('course.exam')
                	    ->withTitle('exam')
                	    ->withActcontent($actcontent)
                	    ->withGlobalvals(Controller::getGlobalvals());
	}

	public function choice()
	{
	    $actcontent = (new AdminUserFunc())->getUserCourse();
	    $retview = 'course.choice';

	    if(Input::get('iscontent') == 1)
	    {
	        $retview = 'admin.usercourse.coursechoice';
	    }

	    if($actcontent->action == 'choose')
	    {
	        $retview = 'course.choiceopt';
	    }
	    elseif($actcontent->action == 'change')
	    {
	    	$retview = 'course.changeopt';
	    }

	    return $this->getUserView($retview)
                	    ->withTitle('choice')
                	    ->withActcontent($actcontent)
                	    ->withGlobalvals(Controller::getGlobalvals());
	}

	public function score()
	{
	    $actcontent = (new AdminUserFunc())->getUserScore();
	    return $this->getUserView('course.score')
                	    ->withTitle('score')
                	    ->withActcontent($actcontent)
                	    ->withGlobalvals(Controller::getGlobalvals());
	}
}
