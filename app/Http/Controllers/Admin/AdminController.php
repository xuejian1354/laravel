<?php namespace App\Http\Controllers\Admin;

use Input,Auth,DB;
use Carbon\Carbon;
use App\User;
use App\Model\Hardware\Gateway;
use App\Model\Hardware\Device;
use App\Model\DBStatic\Grade;
use App\Model\DBStatic\Consolemenu;
use App\Model\DBStatic\Globalval;
use App\Model\DBStatic\Privilege;
use App\Model\DBStatic\Devtype;
use App\Model\DBStatic\Devcmd;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Model\Room\Room;
use App\Model\Course\Course;
use App\Model\DBStatic\Roomtype;
use App\Model\DBStatic\Roomaddr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use App\Model\DBStatic\Cycle;
use App\Model\DBStatic\Term;
use App\Http\Controllers\ExcelController;
use Illuminate\Database\QueryException;
use App\Model\DBStatic\News;
use App\Model\DBStatic\Idgrade;
use App\Model\DBStatic\Academy;
use App\Model\DBStatic\Classgrade;

class AdminController extends Controller {

	protected  $grades = [1, 2, 3, 4];

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getGradeFromVal($val)
	{
		$grades = Grade::all();
		foreach($grades as $grade)
		{
			if ($grade->val == $val)
			{
				return $grade->grade;
			}
		}

		return 4;
	}

	public function index()
	{
		//$action = isset($_GET['action'])?$_GET['action']:"#";
		$actions = explode('/', Input::get('action'));

		$amenu = "#";
		$menus = Consolemenu::all();
		$mmenus = array();

		foreach ($menus as $menu)
		{
			if($actions[0] == $menu->action
				|| ($actions[0] == 'setting' && $menu->mmenu == '设置'))
			{
				if($amenu == "#")
				{
					$amenu = $menu;
					$amenu['caction'] = $menu->action;
				}
			}
			array_push($mmenus, $menu->mmenu);
		}

		if($amenu == "#")
		{
			$amenu = $menus[0];
			$amenu['caction'] = $menus[0]->action;
		}

		if(isset($actions[1]))
		{
			$amenu['caction'] = $actions[1];
		}

		$umenus = array_unique($mmenus);
		$nmenus = array();
		foreach($umenus as $umenu)
		{
			foreach ($menus as $menu)
			{
				if ($umenu == $menu->mmenu)
				{
					array_push($nmenus, $menu);
					break;
				}
			}
		}

		if($amenu->action == "courselist" || $amenu->action == "courseimport")
		{
			$rooms = Room::all();
			$roomnames = array();
			foreach ($rooms as $room)
			{
				array_push($roomnames, $room->name);
			}
			sort($roomnames);

			$cycles = Cycle::all();
			$cyclestr = array();
			foreach ($cycles as $cycle)
			{
				array_push($cyclestr, $cycle->val);
			}
			//sort($cyclestr);

			$termstr = array();
			foreach (Term::all() as $term)
			{
				array_push($termstr, $term->val);
			}
			rsort($termstr);

			$teacherstr = array();
			foreach(User::all() as $user)
			{
				if($user->grade <= 2)
				{
					array_push($teacherstr, $user->name);
				}
			}
			sort($teacherstr);

			return view('admin.admin')
					->withCourses(Course::all())
					->withRoomnames($roomnames)
					->withRoomnamestr(json_encode($roomnames))
					->withCycles($cyclestr)
					->withCyclestr(json_encode($cyclestr))
					->withTerms($termstr)
					->withTermstr(json_encode($termstr))
					->withTeachers($teacherstr)
					->withTeacherstr(json_encode($teacherstr))
					->withGlobalvals(Controller::getGlobalvals())
					->withMenus($menus)
					->withNmenus($nmenus)
					->withAmenu($amenu);
		}
		else if($amenu->action == "roomstats"
					|| $amenu->action == "roomctrl"
					|| $amenu->action == "roomimport")
		{
			if($amenu['caction'] == 'opt')
			{
				if(isset($_GET['roomsn']))
				{
					$room = DB::table('rooms')->where('sn', Input::get('roomsn'))->get();
					if(count($room) > 0)
					{
						$devices = Device::all();
						$devtypes = Devtype::all();
						$devcmds = Controller::getDevCmds();
						$devargs = array();

						foreach ($devices as $device)
						{
							foreach ($devcmds as $devcmd)
							{
								if($device->dev_type == $devcmd->dev_type)
								{
									$device['iscmdfound'] = 1;
									goto devcmdfoundend;
								}
							}
							$device['iscmdfound'] = 0;
							devcmdfoundend:;

							foreach($devtypes as $devtype)
							{
								if ($device->dev_type == $devtype->devtype)
								{
									$device['devtypename'] = $devtype->val;
								}
							}

							if($device->area == $room[0]->name)
							{
								array_push($devargs, $device);
							}
						}

						if(count($devargs) > 0)
						{
							return view('admin.admin')
										->withRoom($room[0])
										->withGlobalvals(Controller::getGlobalvals())
										->withDevcmds($devcmds)
										->withDevices($devargs)
										->withMenus($menus)
										->withNmenus($nmenus)
										->withAmenu($amenu);
						}
						else
						{
							return '<script type="text/javascript">window.location.replace("/admin?action=roomctrl");alert("该教室中没有设备");</script>';
						}
					}
				}

				return $this->backView('未找到教室');
			}

			$rooms = Room::all();
			foreach ($rooms as $room)
			{
				foreach (Roomtype::all() as $roomtype)
				{
					if ($roomtype->roomtype == $room->roomtype)
					{
						$room->roomtypestr = $roomtype->val.'('.$roomtype->roomtype.')';
						break;
					}
				}

				foreach (Roomaddr::all() as $roomaddr)
				{
					if ($roomaddr->roomaddr == $room->addr)
					{
						$room->addrstr = $roomaddr->val.'('.$roomaddr->roomaddr.')';
						break;
					}
				}

				if($room->status == '1')
				{
					$room->statusstr = '正使用(1)';
				}
				else
				{
					$room->statusstr = '未使用(0)';
				}
			}

			$roomtypestr = array();
			foreach(Roomtype::all() as $roomtype)
			{
				array_push($roomtypestr, $roomtype->val.'('.$roomtype->roomtype.')');
			}
			//sort($roomtypestr);

			$roomaddrstr = array();
			foreach(Roomaddr::all() as $roomaddr)
			{
				array_push($roomaddrstr, $roomaddr->val.'('.$roomaddr->roomaddr.')');
			}
			//sort($roomaddrstr);

			$userstr = array();
			$ownerstr = array();
			foreach(User::all() as $user)
			{
				if($user->privilege >= 4)
				{
					array_push($userstr, $user->name);
				}

				if($user->privilege >= 5)
				{
					array_push($ownerstr, $user->name);
				}
			}
			sort($userstr);
			sort($ownerstr);

			return view('admin.admin')
					->withRooms($rooms)
					->withRoomtypes($roomtypestr)
					->withRoomtypestr(json_encode($roomtypestr))
					->withRoomaddrs($roomaddrstr)
					->withRoomaddrstr(json_encode($roomaddrstr))
					->withUsers($userstr)
					->withUserstr(json_encode($userstr))
					->withOwners($ownerstr)
					->withOwnerstr(json_encode($ownerstr))
					->withGlobalvals(Controller::getGlobalvals())
					->withMenus($menus)
					->withNmenus($nmenus)
					->withAmenu($amenu);
		}
		else if($amenu->action == "devstats" || $amenu->action == "devctrl")
		{
			$gateways = Gateway::all();
			$devices = Device::all();
			$devtypes = Devtype::all();
			$devcmds = Controller::getDevCmds();
			$gwargs = array();
			$devargs = array();

			foreach ($gateways as $gateway)
			{
				if($amenu['caction'] == 'gwedit' && isset($_GET['id']) && $gateway->id != Input::get('id'))
				{}
				else
				{
					array_push($gwargs, $gateway);
				}
			}

			foreach ($devices as $device)
			{
				foreach ($devcmds as $devcmd)
				{
					if($device->dev_type == $devcmd->dev_type)
					{
						$device['iscmdfound'] = 1;
						goto cmdfoundend;
					}
				}
				$device['iscmdfound'] = 0;
				cmdfoundend:;

				foreach($devtypes as $devtype)
				{
					if ($device->dev_type == $devtype->devtype)
					{
						$device['devtypename'] = $devtype->val;
					}
				}

				if(($amenu['caction'] == 'devedit'
						&& isset($_GET['id']) && $device->id != Input::get('id'))
					|| ($amenu['caction'] == 'async'
						&& isset($_GET['area']) && $device->area != Input::get('area')))
				{}
				else
				{
					array_push($devargs, $device);
				}
			}

			if(Auth::user()->grade == 1 || Auth::user()->privilege == 5)
			{
				$room = null;
				if($amenu['caction'] == 'async')
				{
					$async = 'admin.devstats.gwasync';
					if(Input::get('tabpos') == 1)
					{
						$async = 'admin.devstats.devasync';
						if(isset($_GET['area']))
						{
							$room = DB::table('rooms')->where('name', Input::get('area'))->get();
							$async = 'admin.roomctrl.devasync';
						}
					}

					return view($async)
								->withRoom($room[0])
								->withGlobalvals(Controller::getGlobalvals())
								->withDevcmds($devcmds)
								->withMenus($menus)
								->withNmenus($nmenus)
								->withAmenu($amenu)
								->withUsers(User::all())
								->withGateways($gwargs)
								->withDevices($devargs);
				}
				else
				{
					return view('admin.admin')
								->withGlobalvals(Controller::getGlobalvals())
								->withDevcmds(Controller::getDevCmds())
								->withMenus($menus)
								->withNmenus($nmenus)
								->withAmenu($amenu)
								->withAreas(Room::all())
								->withUsers(User::all())
								->withGateways($gwargs)
								->withDevices($devargs);
				}
			}
			else
			{
				return view('errors.permitts');
			}
		}
		else if($amenu->action == "usermanage")
		{
			$args = array();
			$users = User::all();
			$grades = Grade::all();
			$privileges = Privilege::all();
			foreach($grades as $grade)
			{
				$grade['count'] = 0;
			}

			foreach ($users as $user)
			{
				foreach($grades as $grade)
				{
					if($user->grade == $grade->grade)
					{
						$grade['count'] += 1;
						$user['gradename'] = $grade->val;
						$user['index'] = $grade['count'];
					}
				}

				if($amenu['caction'] == 'edit' && isset($_GET['id']) && $user->id != Input::get('id'))
				{}
				else
				{
					array_push($args, $user);
				}
			}

			if($amenu['caction'] == 'edit' && Auth::user()->privilege < 5)
			{
				return view('errors.permitts');
			}

			if(Auth::user()->grade == 1 || Auth::user()->privilege == 5)
			{
				return view('admin.admin')
							->withGlobalvals(Controller::getGlobalvals())
							->withMenus($menus)
							->withNmenus($nmenus)
							->withAmenu($amenu)
							->withGrades($grades)
							->withPrivileges($privileges)
							->withAreas(Room::all())
							->withArgs($args);
			}
			else
			{
				return view('errors.permitts');
			}
		}
		else if($amenu->action == "userinfo")
		{
			if(Auth::user()->grade == 1 || Auth::user()->privilege == 5)
			{
				if($amenu['caction'] == 'newscontent')
				{
					$news = News::find(Input::get('id'));
					return view('admin.userinfo.newscontent')
								->withNews($news);
				}
				else if($amenu['caction'] == 'addnews')
				{
					return view('admin.userinfo.addnews')
							->withIdgrades(Idgrade::all())
							->withAcademies(Academy::all())
							->withclassgrades(Classgrade::all())
							->withUsers(User::all());
				}
				else if($amenu['caction'] == 'newsedts')
				{
					$news = array();
					$eleIds = json_decode(Input::get('data'));

					$idgrades = Idgrade::all();
					$academies = Academy::all();
					$classgrades = Classgrade::all();
					$users = User::all();

					foreach ($eleIds as $eleId)
					{
						$new = News::find($eleId);
						if($new != null)
						{
							switch($new->allowgrade)
							{
							case 1:
								$new->allowtext = '全校';
								break;

							case 2:
								$new->allowtext = '院系';
								foreach ($academies as $academy)
								{
									if($academy->academy == $new->visitor)
									{
										$new->visitortext = $academy->val;
									}
								}
								break;

							case 3:
								$new->allowtext = '专业';
								foreach ($classgrades as $classgrade)
								{
									if($classgrade->classgrade == $new->visitor)
									{
										$new->visitortext = $classgrade->val;
									}
								}
								break;

							case 4:
								$new->allowtext = '班级';
								foreach ($classgrades as $classgrade)
								{
									if($classgrade->classgrade == $new->visitor)
									{
										$new->visitortext = $classgrade->val;
									}
								}
								break;

							case 5:
								$new->allowtext = '指定用户';
								foreach ($users as $user)
								{
									if($user->name == $new->visitor)
									{
										$new->visitortext = $user->name;
									}
								}
								break;
							}
							array_push($news, $new);
						}
					}

					return view('admin.userinfo.newsedts')
								->withIdgrades($idgrades)
								->withAcademies($academies)
								->withclassgrades($classgrades)
								->withUsers($users)
								->withEleids(json_encode($eleIds))
								->withNews($news);
				}

				//$news = News::all();
				$news = DB::select('SELECT * FROM news ORDER BY updated_at DESC');
				foreach ($news as $new)
				{
					foreach (Idgrade::all() as $idgrade)
					{
						if ($new->allowgrade == $idgrade->idgrade)
						{
							$new->allowgradestr = $idgrade->val.'('.$idgrade->idgrade.')';
							goto endnews;
						}
					}
					$new->allowgradestr = '未识别('.$new->allowgrade.')';
					endnews:;
				}

				$classgrades = Classgrade::all();
				foreach ($classgrades as $classgrade)
				{
					foreach (Academy::all() as $academy)
					{
						if($academy->academy == $classgrade->academy)
						{
							$classgrade->academystr = $academy->val;
						}
					}
				}

				return view('admin.admin')
							->withGlobalvals(Controller::getGlobalvals())
							->withMenus($menus)
							->withNmenus($nmenus)
							->withAmenu($amenu)
							->withNews($news)
							->withAcademies(Academy::all())
							->withClassgrades($classgrades)
							->withGrades(Grade::all());
			}
			else
			{
				return view('errors.permitts');
			}
		}
		else if($amenu->action == "password")
		{
			if(Auth::user()->grade == 1 || Auth::user()->privilege == 5)
			{
				return view('admin.admin')
						->withUsers(User::all())
						->withGlobalvals(Controller::getGlobalvals())
						->withMenus($menus)
						->withNmenus($nmenus)
						->withAmenu($amenu);
			}
			else
			{
				return view('errors.permitts');
			}
		}

		if(Auth::user()->grade == 1 || Auth::user()->privilege == 5)
		{
			return view('admin.admin')
					->withGlobalvals(Controller::getGlobalvals())
					->withMenus($menus)
					->withNmenus($nmenus)
					->withAmenu($amenu);
		}
		else
		{
			return view('errors.permitts');
		}
	}

	public function userdel()
	{
		User::find(Input::get('id'))->delete();
		return redirect("admin?action=usermanage&tabpos=".Input::get('tabpos'));
	}

	public function useredit()
	{
		$user = User::find(Input::get('id'));

		DB::table('gateways')
			->where('owner', $user->name)
			->update([
					'owner' => Input::get('name'),
					'updated_at' => new Carbon
			]);

		DB::table('devices')
			->where('owner', $user->name)
			->update([
					'owner' => Input::get('name'),
					'updated_at' => new Carbon
			]);

		$user->name = Input::get('name');
		$user->grade = $this->getGradeFromVal(Input::get('grade'));
		$user->privilege = intval(substr(Input::get('privilege'), 0, 1), 10);

		$area = Input::get('area');
		if ($area != null && $area != 'null')
		{
			$user->area = $area;
		}
		$user->save();

		return redirect("admin?action=usermanage&tabpos=".($user->grade-1));
	}

	public function gwdel()
	{
		Gateway::find(Input::get('id'))->delete();
		return redirect("admin?action=devstats&tabpos=".Input::get('tabpos'));
	}

	public function gwedit()
	{
		$gateway = Gateway::find(Input::get('id'));
		$gateway->name = Input::get('name');
		$area = Input::get('area');
		if ($area != null && $area != 'null')
		{
			$gateway->area = $area;
		}
		$gateway->ispublic = Input::get('ispublic');
		$gateway->owner = Input::get('owner');
		$gateway->save();

		return redirect("admin?action=devstats&tabpos=0");
	}

	public function devdel()
	{
		Device::find(Input::get('id'))->delete();
		return redirect("admin?action=devstats&tabpos=".Input::get('tabpos'));
	}

	public function devmvarea()
	{
		$device = Device::find(Input::get('id'));
		$device->area = '未设置';
		$device->save();

		return redirect("admin?action=roomctrl/opt&roomsn=".Input::get('roomsn'));
	}

	public function devedit()
	{
		$device = Device::find(Input::get('id'));
		$device->name = Input::get('name');
		$area = Input::get('area');
		if ($area != null && $area != 'null')
		{
			$device->area = $area;
		}
		$device->ispublic = Input::get('ispublic');
		$device->owner = Input::get('owner');
		$device->save();

		$roomsn = Input::get('roomsn');
		if($roomsn == null )
		{
			return redirect("admin?action=devstats&tabpos=1");
		}
		else
		{
			$room = DB::table('rooms')->where('name', $area)->get();
			if(count($room) > 0)
			{
				$roomsn = $room[0]->sn; 
			}
			return redirect("admin?action=roomctrl/opt&roomsn=".$roomsn);
		}
	}
	
	public function roomedt()
	{
		$roomtypes = Roomtype::all();
		$roomaddrs = Roomaddr::all();

		$data = Input::get('data');
		$dobjs = json_decode($data);

		foreach ($dobjs as $dobj)
		{
			$room = Room::find((int)$dobj->id);
			if($room->sn == $dobj->sn)
			{
				$room->name = $dobj->name;
				
				foreach($roomtypes as $roomtype)
				{
					$roomtypestr = $roomtype->val.'('.$roomtype->roomtype.')'; 
					if($roomtypestr == $dobj->roomtypestr)
					{
						$room->roomtype = $roomtype->roomtype;
					}
				}

				foreach($roomaddrs as $roomaddr)
				{
					$roomaddrstr = $roomaddr->val.'('.$roomaddr->roomaddr.')';
					if($roomaddrstr == $dobj->roomaddrstr)
					{
						$room->addr = $roomaddr->roomaddr;
					}
				}
				
				if($dobj->statustr == '正使用(1)')
				{
					$room->status = '1';
				}
				else
				{
					$room->status = '0';
				}
				
				$room->user = $dobj->user;
				$room->owner = $dobj->owner;
				
				$room->save();
			}
		}

		return redirect("admin?action=roomstats");
	}

	public function roomdel()
	{
		$data = Input::get('data');
		$dobjs = json_decode($data);
	
		foreach ($dobjs as $dobj)
		{
			$room = Room::find((int)$dobj->id);
			if($room->sn == $dobj->sn)
			{
				$room->delete();
			}
		}
	
		return redirect("admin?action=roomstats");
	}

	public function roomadd()
	{
		$data = Input::get('data');
		$room = json_decode($data);

		$roomtype;
		$roomaddr;
		preg_match('/\d+/', $room->roomtype, $roomtype);
		preg_match('/\d+/', $room->addr, $roomaddr);
		$roomtype = $roomtype[0];
		$roomaddr = isset($roomaddr[0])?$roomaddr[0]:'';

		try {
			Room::create([
					'sn' => ExcelController::genRoomSN($room->name, $roomtype, $roomaddr),
					'name' => $room->name,
					'roomtype' => $roomtype,
					'addr' => $roomaddr,
					'status' => ExcelController::getRoomStatus($room->status),
					'user' => $room->user,
					'owner' => $room->owner,
			]);
		} catch (QueryException $e) {
			return '<script type="text/javascript">history.back(-1);alert("添加错误，请检查该教室是否已经存在");</script>';
		}
	
		return redirect("admin?action=roomstats");
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
	
		return redirect("admin?action=courselist");
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

	public function addnews()
	{
		$content = array();
		$title = Input::get('title');
		if($title == null)
		{
			return $this->backView("标题不能为空");
		}

		$content['title'] = $title;

		$subtitle = Input::get('subtitle');
		if($subtitle != null)
		{
			$content['subtitle'] = $subtitle;
		}
		else
		{
			$content['subtitle'] = $title;
		}

		$allowgrade = Input::get('allowgrade');
		if($allowgrade == null)
		{
			$content['allowgrade'] = '1';
		}
		else
		{
			foreach (Idgrade::all() as $idgrade)
			{
				if($idgrade->val == $allowgrade)
				{
					$content['allowgrade'] = $idgrade->idgrade;

					switch ($idgrade->idgrade)
					{
					case 2:
						foreach (Academy::all() as $academy)
						{
							if($academy->val == Input::get('visitor'))
							{
								$content['visitor'] = $academy->academy;
							}
						}
						break;

					case 3:
					case 4:
						foreach (Classgrade::all() as $classgrade)
						{
							if($classgrade->val == Input::get('visitor'))
							{
								$content['visitor'] = $classgrade->classgrade;
							}
						}
						break;

					case 5:
						$content['visitor'] = Input::get('visitor');
						break;
					}

					break;
				}
			}
		}

		$content['owner'] = Auth::user()->name;

		$text = Input::get('text');
		if($text != null)
		{
			$content['text'] = $text;
		}

		News::create($content);

		return redirect("admin?action=userinfo&tabpos=0");
	}

	public function newsdel(){
		$data = json_decode(Input::get('data'));
		foreach ($data as $id)
		{
			News::find($id)->delete();
		}

		return redirect("admin?action=userinfo&tabpos=0");
	}

	public function newsedts(){
		$newsids = json_decode(Input::get('newsids'));
		for ($index = count($newsids)-1; $index >= 0; $index--)
		{
			$new = News::find($newsids[$index]);
			$content = array();
			$title = Input::get('title'.$newsids[$index]);
			if($title == null)
			{
				return $this->backView("标题不能为空");
			}

			$new->title = $title;

			$subtitle = Input::get('subtitle'.$newsids[$index]);
			if($subtitle != null)
			{
				$new->subtitle = $subtitle;
			}
			else
			{
				$new->subtitle = $title;
			}

			$allowgrade = Input::get('allowgrade'.$newsids[$index]);
			if($allowgrade == null)
			{
				$new->allowgrade = '1';
			}
			else
			{
				foreach (Idgrade::all() as $idgrade)
				{
					if($idgrade->val == $allowgrade)
					{
						$new->allowgrade = $idgrade->idgrade;

						switch ($idgrade->idgrade)
						{
							case 2:
								foreach (Academy::all() as $academy)
								{
									if($academy->val == Input::get('visitor'.$newsids[$index]))
									{
										$new->visitor = $academy->academy;
									}
								}
								break;

							case 3:
							case 4:
								foreach (Classgrade::all() as $classgrade)
								{
									if($classgrade->val == Input::get('visitor'.$newsids[$index]))
									{
										$new->visitor = $classgrade->classgrade;
									}
								}
								break;

							case 5:
								$new->visitor = Input::get('visitor'.$newsids[$index]);
								break;
						}
						break;
					}
				}
			}

			$new->owner = Auth::user()->name;

			$text = Input::get('text'.$newsids[$index]);
			if($text != null)
			{
				$new->text = $text;
			}

			$new->save();
		}

		return redirect("admin?action=userinfo&tabpos=0");
	}

	public function resetpass()
	{
		$email = Input::get('email');
		$newpass = Input::get('new_pass');
		$confirmpass = Input::get('confirm_pass');

		if($newpass == null)
		{
			return redirect('admin?action=password')->withErrors('No input new password');
		}
	
		if($newpass != $confirmpass)
		{
			return redirect('admin?action=password')->withErrors('Input new password with confirm dismatch');
		}
	
		if(Auth::attempt(['email' => $email, 'password' => $newpass]))
		{
			return redirect('admin?action=password')->withErrors('Input different password with old');
		}

		DB::table('users')
				->where('email', $email)
				->update(['password' => bcrypt($newpass)]);

		$amenu = "#";
		$menus = Consolemenu::all();
		$mmenus = array();

		foreach ($menus as $menu)
		{
			if($menu->action == 'password')
			{
				if($amenu == "#")
				{
					$amenu = $menu;
					$amenu['caction'] = $menu->action;
				}
			}
			array_push($mmenus, $menu->mmenu);
		}

		if($amenu == "#")
		{
			$amenu = $menus[0];
			$amenu['caction'] = $menus[0]->action;
		}

		$umenus = array_unique($mmenus);
		$nmenus = array();
		foreach($umenus as $umenu)
		{
			foreach ($menus as $menu)
			{
				if ($umenu == $menu->mmenu)
				{
					array_push($nmenus, $menu);
					break;
				}
			}
		}

		return $this->getUserView('admin.admin')
							->withUsers(User::all())
							->withGlobalvals(Controller::getGlobalvals())
							->withMenus($menus)
							->withNmenus($nmenus)
							->withAmenu($amenu)
							->withInfo('Reset password success !');
	}

	public static function backView($info = 'Error')
	{
		return '<script type="text/javascript">history.back(-1);alert("'.$info.'");</script>';
	}

}
