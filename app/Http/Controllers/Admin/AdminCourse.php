<?php namespace App\Http\Controllers\Admin;

use Input;
use App\Model\Room\Room;
use App\Model\DBStatic\Cycle;
use App\Model\DBStatic\Term;
use App\User;
use App\Model\Course\Course;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PageTag;

class AdminCourse {

	protected $menus;

	protected $roomnames;
	protected $cyclestr;
	protected $termstr;
	protected $teacherstr;

	public function __construct($menus)
	{
		$this->menus = $menus;

		$rooms = Room::all();
		$this->roomnames = array();
		foreach ($rooms as $room)
		{
			array_push($this->roomnames, $room->name);
		}
		sort($this->roomnames);
		
		$cycles = Cycle::all();
		$this->cyclestr = array();
		foreach ($cycles as $cycle)
		{
			array_push($this->cyclestr, $cycle->val);
		}
		//sort($cyclestr);
		
		$this->termstr = array();
		foreach (Term::all() as $term)
		{
			array_push($this->termstr, $term->val);
		}
		rsort($this->termstr);
		
		$this->teacherstr = array();
		foreach(User::all() as $user)
		{
			if($user->grade <= 2)
			{
				array_push($this->teacherstr, $user->name);
			}
		}
		sort($this->teacherstr);
	}

	public function getCourseView()
	{
	    $courses = Course::all();
	    $pagetag = new PageTag(8, 5, count($courses), $this->menus->getPage());
	    if($pagetag->isAvaliable())
	    {
	        $courses = Course::paginate($pagetag->getRow());
	    }

		return AdminController::getViewWithMenus('admin.admin')
		        ->withPagetag($pagetag)
				->withCourses($courses)
				->withRoomnames($this->roomnames)
				->withRoomnamestr(json_encode($this->roomnames))
				->withCycles($this->cyclestr)
				->withCyclestr(json_encode($this->cyclestr))
				->withTerms($this->termstr)
				->withTermstr(json_encode($this->termstr))
				->withTeachers($this->teacherstr)
				->withTeacherstr(json_encode($this->teacherstr));
	}

	public function courseedt()
	{
		$data = Input::get('data');
		$dobjs = json_decode($data);

		foreach ($dobjs as $dobj)
		{
			$course = Course::find((int)$dobj->id);
			if($course->sn == $dobj->sn)
			{
				if(isset($dobj->course)) $course->course = $dobj->course;
				if(isset($dobj->room)) $course->room = $dobj->room;
				if(isset($dobj->time)) $course->time = $dobj->time;
				if(isset($dobj->cycle)) $course->cycle = $dobj->cycle;
				if(isset($dobj->term)) $course->term = $dobj->term;
				if(isset($dobj->teacher)) $course->teacher = $dobj->teacher;
	
				$course->save();
			}
		}
	
		$page = Input::get('page');
		return redirect("admin?action=courselist&page=".$page);
	}

	public function coursedel()
	{
		$data = Input::get('data');
		$dobjs = json_decode($data);
	
		foreach ($dobjs as $dobj)
		{
			$course = Course::find((int)$dobj->id);
			if($course->sn == $dobj->sn)
			{
				$course->delete();
			}
		}
	
		return redirect("admin?action=courselist");
	}

	public function courseadd()
	{
		$data = Input::get('data');
		$type = Input::get('type');
		$course = json_decode($data);
	
		$sn = ExcelController::genCourseSN($course->course,
				$type,
				$course->room,
				$course->time,
				$course->cycle,
				$course->term);
	
		try {
			Course::create([
					'sn' => $sn,
					'course' => $course->course,
					'coursetype' => $type,
					'room' => $course->room,
					'time' => $course->time,
					'cycle' => $course->cycle,
					'term' => $course->term,
					'teacher' => $course->teacher,
			]);
		} catch (QueryException $e) {
			return '<script type="text/javascript">history.back(-1);alert("添加错误，请检查该课程是否已经存在");</script>';
		}
	
		return redirect("admin?action=courselist");
	}
}
