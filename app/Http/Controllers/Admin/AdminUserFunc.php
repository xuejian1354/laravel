<?php namespace App\Http\Controllers\Admin;

use Input, Auth, DB;
use App\User;
use App\Http\Controllers\Controller;
use App\Model\DBStatic\News;
use App\Model\DBStatic\Academy;
use App\Model\DBStatic\Classgrade;
use App\Model\DBStatic\Userdetail;
use App\Model\DBStatic\Grade;
use App\Model\DBStatic\Userrecord;
use App\Model\DBStatic\Useraction;
use App\Model\DBStatic\Idgrade;
use App\Http\Controllers\PageTag;
use App\Model\DBStatic\Term;
use App\Model\Course\Course;
use App\Model\Room\Room;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\ExcelController;
use App\Model\DBStatic\Globalval;

class AdminUserFunc {

	protected $menus;

	public function __construct($menus)
	{
		$this->menus = $menus;
	}

	public function getFuncView()
	{
		if(Auth::user()->grade == 1 || Auth::user()->privilege == 5)
		{
			$user = null;
			$id = Input::get('id');
			if($id != null)
			{
				$user = User::find($id);
			}

			if($user == null)
			{
				$user = Auth::user();
			}

			if($this->menus->getAmenu()->action == 'useractivity')
			{
			    $news = array();
				$etnews = array();
				$enews = array();

				$user->recvcount = 0;
				$user->noreadcount = 0;
				$user->sendcount = 0;

				$recvnews = News::where('owner', '!=', $user->name)->orderBy('updated_at', 'desc')->get();
				/*$pagetag = new PageTag(2, 5, $recvnews->count(), $this->menus->getPage());
				if($pagetag->isAvaliable())
				{
				    if(Input::get('tabpos') == 0)
				    {
				        $recvnews = $recvnews->paginate($pagetag->getRow());
				    }
				    else
				    {
				        $recvnews = $recvnews->paginate($pagetag->getRow(), ['*'], 'page', 1);
				        $pagetag->setPage(1);
				    }
				}
				$pagetag->setListNum(count($recvnews));
				$recvnewspagetag = $pagetag;*/

				foreach ($recvnews as $recv)
				{
				    array_push($news, $recv);
				}

				$sendnews = News::where('owner', '=', $user->name)->orderBy('updated_at', 'desc');
				$user->sendcount = $sendnews->count();
				$pagetag = new PageTag(3, 5, $sendnews->count(), $this->menus->getPage());
				if($pagetag->isAvaliable())
				{
				    if(Input::get('tabpos') == 1)
				    {
				        $sendnews = $sendnews->paginate($pagetag->getRow());
				    }
				    else
				    {
				        $sendnews = $sendnews->paginate($pagetag->getRow(), ['*'], 'page', 1);
				        $pagetag->setPage(1);
				    }
				}
				else 
				{
				    $sendnews = $sendnews->get();
				}

				$pagetag->setListNum(count($sendnews));
				$sendnewspagetag = $pagetag;

				foreach ($sendnews as $send)
				{
				    array_push($news, $send);
				}

				foreach ($news as $anew)
				{
					$this->addAllowTextToNews($anew);

					$opt = Input::get('opt');
					if($opt == 'all')
					{
						$newsid = Input::get('newsid');
						if($newsid != null && $newsid == $anew->id)
						{
							$lnews = News::find($newsid);
							$userrecord = DB::select('SELECT * FROM userrecords WHERE usersn=\''
														.$user->sn
														.'\' AND action=\'2\' AND optnum=\''
														.$lnews->sn
														.'\'');
							if($userrecord == null)
							{
								$lname = '查看消息:"'.$lnews->title.'"';

								Userrecord::create([
										'sn' => AdminUserInfo::genNewsSN($lname),
										'name' => $lname,
										'usersn' => $user->sn,
										'action' => 2,
										'optnum' => $lnews->sn,
								]);
							}

							return view('admin.userinfo.newscontent')
										->withTabpos(Input::get('tabpos'))
										->withReturnurl('admin?action=useractivity&id='.$id
										    .'&page='.$this->menus->getPage()
										    .'&tabpos='.Input::get('tabpos'))
										->withUser(User::find(Input::get('id')))
										->withNews($anew);
						}
						continue;
					}
					else if($opt == 'more')
					{
						$newsid = Input::get('newsid');
						if($newsid != null && $newsid == $anew->id)
						{
							$lnews = News::find($newsid);
							$userrecord = Userrecord::where('usersn', '=', $user->sn)
                							             ->where('action', '=', '2')
                							             ->where('optnum', '=', $lnews->sn);

							if($userrecord->count() == 0)
							{
								$lname = '查看消息:"'.$lnews->title.'"';

								Userrecord::create([
										'sn' => AdminUserInfo::genNewsSN($lname),
										'name' => $lname,
										'usersn' => $user->sn,
										'action' => 2,
										'optnum' => $lnews->sn,
								]);
							}

							return view('admin.userinfo.newsrecvlist')
										->withTabpos(Input::get('tabpos'))
										->withReturnurl('admin?action=useractivity&id='.$id
										    .'&page='.$this->menus->getPage()
										    .'&tabpos='.Input::get('tabpos'))
										->withUser(User::find(Input::get('id')))
										->withNews($anew);
						}
						continue;
					}
					else if($opt == 'add')
					{
						$newsid = Input::get('newsid');
						if($newsid != null && $newsid == $anew->id)
						{
							return view('admin.userinfo.addnews')
										->withReturnurl('admin?action=useractivity&id='.$id
										    .'&page='.$this->menus->getPage()
										    .'&tabpos='.Input::get('tabpos'))
										->withHasowner(true)
										->withIdgrades(Idgrade::all())
										->withAcademies(Academy::all())
										->withclassgrades(Classgrade::all())
										->withoptuser(User::find(Input::get('id')))
										->withUsers(User::all());
						}
						continue;
					}
					else if($opt == 'edt')
					{
						$newsid = Input::get('newsid');
						if($newsid != null && $newsid == $anew->id)
						{
							$academies = Academy::all();
							$classgrades = Classgrade::all();
							$users = User::all();

							switch($anew->allowgrade)
							{
								case 1:
									$anew->allowtext = '全校';
									break;
						
								case 2:
									$anew->allowtext = '院系';
									foreach ($academies as $academy)
									{
										if($academy->academy == $anew->visitor)
										{
											$anew->visitortext = $academy->val;
										}
									}
									break;
						
								case 3:
									$anew->allowtext = '专业';
									foreach ($classgrades as $classgrade)
									{
										if($classgrade->classgrade == $anew->visitor)
										{
											$anew->visitortext = $classgrade->val;
										}
									}
									break;
						
								case 4:
									$anew->allowtext = '班级';
									foreach ($classgrades as $classgrade)
									{
										if($classgrade->classgrade == $anew->visitor)
										{
											$anew->visitortext = $classgrade->val;
										}
									}
									break;
						
								case 5:
									$anew->allowtext = '指定用户';
									foreach ($users as $user)
									{
										if($user->name == $anew->visitor)
										{
											$anew->visitortext = $user->name;
										}
									}
									break;
							}

							$tabpos = Input::get('tabpos');
							$hasowner = false;
							if($tabpos == 1)
							{
								$hasowner = true;
							}

							return view('admin.userinfo.newsedts')
										->withReturnurl('admin?action=useractivity&id='.$id
										    .'&page='.$this->menus->getPage()
										    .'&tabpos='.$tabpos)
										->withHasowner($hasowner)
										->withIdgrades(Idgrade::all())
										->withAcademies($academies)
										->withclassgrades($classgrades)
										->withEleids('['.$newsid.']')
										->withNews([$anew])
										->withoptuser(User::find(Input::get('id')))
										->withUsers($users);
						}
						continue;
					}

					if(strlen($anew->text) > 600)
					{
						$anew->text = mb_substr($anew->text, 0, 200, "utf-8").' ...';
					}

					if($anew->owner == $user->name)
					{
						$anew->isrecv = false;
						//$user->sendcount++;

						array_push($enews, $anew);
					}
					else
					{
						$anew->isrecv = true;
						$ischoose = false;

						$userdetail = DB::table('userdetails')->where('sn', $user->sn)->get();
						if($userdetail != null)
						{
							$userdetail = $userdetail[0];
						}

						switch($anew->allowgrade)
						{
						case 1: //school
							$ischoose = true;
							break;
						
						case 2: //academy
							if($userdetail == null)
							{
								break;
							}

							if($userdetail->grade == 1)	//administrator
							{
								$ischoose = true;
							}
							else if($userdetail->grade == 2) //teacher
							{
								if($anew->visitor == $userdetail->type)
								{
									$ischoose = true;
								}
							}
							else if($userdetail->grade == 3) //student
							{
								$classgrade = DB::table('classgrades')
								    ->where('classgrade', $userdetail->type)->get();
								if($classgrade != null)
								{
									$classgrade = $classgrade[0];
									if($anew->visitor == $classgrade->academy)
									{
										$ischoose = true;
									}
								}
							}
							break;

						case 3:
						case 4:  //class
							if($userdetail == null)
							{
								break;
							}

							if($userdetail->grade == 1)	//administrator
							{
								$ischoose = true;
							}
							else if($userdetail->grade == 2) //teacher
							{
								$classgrade = DB::table('classgrades')->where('classgrade', $anew->visitor)->get();
								if($classgrade != null)
								{
									$classgrade = $classgrade[0];
									if($classgrade->academy == $userdetail->type)
									{
										$ischoose = true;
									}
								}
							}
							else if($userdetail->grade == 3) //student
							{
								if($anew->visitor == $userdetail->type)
								{
									$ischoose = true;
								}
							}
							break;
						
						case 5:
							$guest = DB::table('users')->where('name', $anew->visitor)->get();
							if($guest != null)
							{
								$guest = $guest[0];
								if($guest->grade == 4)
								{
									$ischoose = true;
									break;
								}
							}

							if($userdetail != null)
							{
								if($userdetail->grade == 1)	//administrator
								{
									$ischoose = true;
								}
								else if($anew->visitor == $user->name)
								{
									$ischoose = true;
								}
							}
							break;
						}
						
						if($ischoose)
						{
							//action=2 looking for news
							$userrecord = DB::select('SELECT * FROM userrecords WHERE usersn=\''
														.$user->sn
														.'\' AND action=\'2\' AND optnum=\''
														.$anew->sn
														.'\'');
							if($userrecord != null)
							{
								$anew->isread = true;
							}
							else
							{
								$user->noreadcount++;
								$anew->isread = false;
							}

							$user->recvcount++;
							array_push($etnews, $anew);
						}
					}
				}

				$recvnewspagetag = new PageTag(3, 5, count($etnews), $this->menus->getPage());
				if($recvnewspagetag->isAvaliable())
				{
    				$tindex = 0;
    				$recvrow = $recvnewspagetag->getRow();
    				$recvpage = $recvnewspagetag->getPage();
    				
    				$recvhindex = $recvrow*($recvpage-1);
    				$recvtindex = $recvhindex + $recvrow;
    				$recvcount = count($etnews);
    				if($recvtindex > $recvcount)
    				{
    				    $recvtindex = $recvcount;
    				}
    				
    				for($i=$recvhindex; $i < $recvtindex; $i++)
    				{
    				    array_push($enews, $etnews[$i]);
    				}
				}
				else
				{
				    foreach ($etnews as $tnew)
				    {
				        array_push($enews, $tnew);
				    }
				}

				return AdminController::getViewWithMenus('admin.admin', null, $user)
				            ->withRecvnewspagetag($recvnewspagetag)
				            ->withSendnewspagetag($sendnewspagetag)
							->withNews($enews)
							->withUser($user);
			}
			else if($this->menus->getAmenu()->action == 'usercourse')
			{
			    if($this->menus->getAmenu()->caction == 'arrange')
			    {
			        if($user->grade == 1)
			        {
    			        $term = Term::where('val', '=', Input::get('term'))->get()[0];
    			        if($term->coursearrange == 0)
    			        {
        			        $term->coursearrange = true;
        			        $term->arrangestart = Input::get('start');
        			        $term->arrangeend = Input::get('end');
        			        //dd($term);
        			        $term->save();
    			        }

    			        $teachers = User::where('grade', '=', 2)->orderBy('name', 'asc')->get();
    			        $arrangetname = $teachers[0]->name;
    			        if(Input::get('teacher'))
    			        {
    			            $arrangetname = Input::get('teacher'); 
    			        }

    			        $view = 'admin.admin';
    			        if(Input::get('isweektbody') == 'true')
    			        {
    			            $view = 'admin.usercourse.weektbody';;
    			        }

    			        return AdminController::getViewWithMenus($view, null, $user)
                			        ->withTerm($term)
                			        ->withRooms(Room::all())
                			        ->withTeachers($teachers)
                			        ->withArrangename($arrangetname)
                			        ->withCoursetime($this->getCoursetimeArray())
                			        ->withCoursetable($this->getCourseForWeek($term->val, $arrangetname))
                			        ->withUser($user);
			        }
			        else
			        {
			            return view('errors.permitts');
			        }
			    }
			    elseif($user->grade == 2)
			    {
			        $terms = Term::query()->orderBy('val', 'desc')->get();
			        $term = $terms[0];
			        
			        $gterm = Term::where('val', '=', Controller::getGlobalvals()['curterm'])->get();
			        if(count($gterm) > 0)
			        {
			            $term = $gterm[0];
			        }

			        if(Input::get('term') != null)
			        {
			            $aterm = Term::where('val', '=', Input::get('term'))->get();
			            if(count($aterm) > 0)
			            {
			                $term = $aterm[0];
			            }
			        }

			        return AdminController::getViewWithMenus('admin.admin', null, $user)
                			        ->withCoursetime($this->getCoursetimeArray())
                			        ->withCoursetable($this->getCourseForWeek($term->val, $user->name))
                			        ->withTerm($term)
                			        ->withTerms($terms)
                			        ->withAdmins(User::where('grade', '=', '1')->get())
                			        ->withUser($user);
			    }

			    return AdminController::getViewWithMenus('admin.admin', null, $user)
			                 ->withTerms(Term::query()->orderBy('val', 'desc')->get())
			                 ->withUser($user);
			}
			else if($this->menus->getAmenu()->action == 'userdetails')
			{
				$userdetail = DB::table('userdetails')->where('sn', $user->sn)->get();
				if($userdetail != null)
				{
					$userdetail = $userdetail[0];
					$userdetail->typestr = '未识别';

					if($userdetail->grade == 2)
					{
						foreach (Academy::all() as $academy)
						{
							if($academy->academy == $userdetail->type)
							{
								$userdetail->typestr = $academy->val;
								break;
							}
						}
					}
					else
					{
						foreach (Classgrade::all() as $classgrade)
						{
							if($classgrade->classgrade == $userdetail->type)
							{
								$userdetail->typestr = $classgrade->val;
								break;
							}
						}
					}
				}

				return AdminController::getViewWithMenus('admin.admin', null, $user)
							->withUserdetail($userdetail)
							->withAcademies(Academy::all())
							->withClassgrades(Classgrade::all())
							->withUser($user);
			}

			return AdminController::getViewWithMenus('admin.admin', null, $user)
						->withUser($user);
		}
		else
		{
			return view('errors.permitts');
		}
	}

	function getCoursetimeArray()
	{
	    return ['1,2' => Globalval::where('name', '=', '1-2-classtime')->get()[0]->fieldval,
        	    '3,4' => Globalval::where('name', '=', '3-4-classtime')->get()[0]->fieldval,
        	    '5,6' => Globalval::where('name', '=', '5-6-classtime')->get()[0]->fieldval,
        	    '7,8' => Globalval::where('name', '=', '7-8-classtime')->get()[0]->fieldval,
        	    '9,10,11' => Globalval::where('name', '=', '9-11-classtime')->get()[0]->fieldval,
        	    ];
	}

	public function adddetail() {
		$info = null;
		$userdetail = null;
		$content = array();

		$sn = Input::get('sn');
		if($sn != null)
		{
			$content['sn'] = $sn;
		}

		$user = DB::table('users')->where('sn', $sn)->get();
		if($user == null)
		{
			$user = Auth::user();
		}
		else
		{
			$user = $user[0];
		}

		$name = Input::get('userdetailname');
		if($name != null && $name != '')
		{
			$content['name'] = $name;
		}
		else
		{
			$info = '添加失败，姓名不能为空';
			goto adddtailreturn;
		}

		$sexuality = Input::get('sexuality');
		if($sexuality != null)
		{
			$content['sexuality'] = $sexuality;
		}

		$people = Input::get('people');
		if($people != null)
		{
			$content['people'] = $people;
		}

		$num = Input::get('num');
		if($num != null && $num != '')
		{
			$content['num'] = $num;
		}
		else
		{
			$info = '添加失败，工号或学号出错';
			goto adddtailreturn;
		}

		$gradestr = Input::get('gradestr');
		if(($gradestr != null && $gradestr != '')
			|| ($user->grade != 2 && $user->grade != 3))
		{
			$content['grade'] = $user->grade;

			foreach (Grade::all() as $dbgrade)
			{
				if($dbgrade->val == $gradestr)
				{
					$content['grade'] = $dbgrade->grade;
					break;
				}
			}
		}
		else
		{
			$info = '添加失败，未识别身份信息';
			goto adddtailreturn;
		}

		$typestr = Input::get('typestr');
		if(($typestr != null && $typestr != '')
			|| ($user->grade != 2 && $user->grade != 3))
		{
			switch($content['grade'])
			{
			case 2:
				foreach (Academy::all() as $academy)
				{
					if($academy->val == $typestr)
					{
						$content['type'] = $academy->academy;
						break;
					}
				}
				break;

			case 3:
				foreach (Classgrade::all() as $classgrade)
				{
					if($classgrade->val == $typestr)
					{
						$content['type'] = $classgrade->classgrade;
						break;
					}
				}
				break;
			}
		}
		else
		{
			$info = '添加失败，未识别班级或学院';
			goto adddtailreturn;
		}

		$birthdate = Input::get('birthdate');
		if($birthdate != null)
		{
			$content['birthdate'] = $birthdate;
		}

		$polity = Input::get('polity');
		if($polity != null)
		{
			$content['polity'] = $polity;
		}

		$native = Input::get('native');
		if($native != null)
		{
			$content['native'] = $native;
		}

		$cellphone = Input::get('cellphone');
		if($cellphone != null)
		{
			$content['cellphone'] = $cellphone;
		}

		$civinum = Input::get('civinum');
		if($civinum != null)
		{
			$content['civinum'] = $civinum;
		}

		$address = Input::get('address');
		if($address != null)
		{
			$content['address'] = $address;
		}

		$qq = Input::get('qq');
		if($qq != null)
		{
			$content['qq'] = $qq;
		}

		$email = Input::get('email');
		if($email != null)
		{
			$content['email'] = $email;
		}

		$userdetail = DB::table('userdetails')->where('sn', $sn)->get();
		if($userdetail != null)
		{
			DB::table('userdetails')
					->where('sn', $sn)
					->update($content);

			$userdetail = DB::table('userdetails')->where('sn', $sn)->get();
			if($userdetail != null)
			{
				$userdetail = $userdetail[0];
				$userdetail->typestr = $typestr;
				$info = '成功修改 '.$user->name.' 的个人资料';
			}
			else
			{
				$info = '修改失败';
			}
		}
		else
		{
			Userdetail::create($content);

			$userdetail = DB::table('userdetails')->where('sn', $sn)->get();
			if($userdetail != null)
			{
				$userdetail = $userdetail[0];
				$userdetail->typestr = $typestr;
				$info = '成功添加 '.$user->name.' 的个人资料';
			}
			else
			{
				$info = '添加失败';
			}
		}

adddtailreturn:
		return AdminController::getViewWithMenus('admin.admin', 'userdetails')
									->withAcademies(Academy::all())
									->withClassgrades(Classgrade::all())
									->withUserdetail($userdetail)
									->withUser($user)
									->withInfo($info);
	}

	public function addAllowTextToNews($news)
	{
		switch($news->allowgrade)
		{
			case 1:
				$news->allowtext = '全校';
				break;
					
			case 2:
				foreach (Academy::all() as $academy)
				{
					if($academy->academy == $news->visitor)
					{
						$news->allowtext = $academy->val;
						break;
					}
				}
				break;
					
			case 3:
			case 4:
				foreach (Classgrade::all() as $classgrade)
				{
					if($classgrade->classgrade == $news->visitor)
					{
						$news->allowtext = $classgrade->val;
						break;
					}
				}
				break;
					
			case 5:
				foreach (User::all() as $user)
				{
					if($user->name == $news->visitor)
					{
						$news->allowtext = $user->name;
						if($user->grade == 4)
						{
							$news->allowtext = '全校';
						}
						break;
					}
				}
				break;
		}
	}

	public function newsadel(){
		$userid = Input::get('userid');
		$newsid = Input::get('newsid');
		$tabpos = Input::get('tabpos');

		$user = User::find($userid);
		if($user->grade == 4
			|| $user->privilege == 1
			|| Auth::user()->grade == 4
			|| Auth::user()->privilege == 1
			|| (News::find($newsid)->owner != Auth::user()->name
				&& Auth::user()->grade != 1 && Auth::user()->privilege != 5))
		{
			return view('errors.permitts');
		}

		if($tabpos == null)
		{
			$tabpos = 1;
		}

		News::find($newsid)->delete();
	
		return redirect("admin?action=useractivity&id=".$userid."&tabpos=".$tabpos);
	}
	
	public function coursearrange()
	{
	    $data = Input::get('data');
	    $type = Input::get('type');
	    $course = json_decode($data);

	    if($course->remarks == '')
	    {
	        $course->remarks = Globalval::where('name', '=', 'coursetimes')->get()[0]->fieldval;
	    }
	
	    $cobj = Course::where('term', '=', $course->term)
	               ->where('time', '=', $course->time)
	               ->where('room', '=', $course->room)
	               ->orderBy('id', 'desc');
	    
	    if($cobj->count() > 0)
	    {
	        $tcourse = $cobj->get()[0];

	        if(Input::get('force') == 1)
	        {
    	        $tcourse->course = $course->course;
    	        $tcourse->cycle = $course->cycle;
    	        $tcourse->teacher = $course->teacher;
    	        $tcourse->remarks = $course->remarks;
    	        $tcourse->save();
	        }
	        else
	        {
	            $warning = '位于『'.$tcourse->room
	                           .'』'
	                           .$tcourse->time
	                           .'已经存在课程『'
	                           .$tcourse->course.'』，任课教师：'
	                           .$tcourse->teacher
	                           .'。是否强制替换？';

	           return redirect(Input::get('returnurl')
	                           .'&exist=1&ecourse='
	                           .$course->course
	                           .'&etime='
	                           .$course->time
	                           .'&eroom='
	                           .$course->room
	                           .'&eremarks='
	                           .$course->remarks
	                           .'&warning='
	                           .$warning);
	        }
	    }
	    else
	    {
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
    	            'coursetype' => 1,
    	            'room' => $course->room,
    	            'time' => $course->time,
    	            'cycle' => $course->cycle,
    	            'term' => $course->term,
    	            'teacher' => $course->teacher,
    	            'remarks' => $course->remarks,
    	        ]);
        	    } catch (QueryException $e) {
        	        return '<script type="text/javascript">history.back(-1);alert("添加错误，请检查该课程是否已经存在");</script>';
        	    }
	    }

	    return redirect(Input::get('returnurl'));
	}
	
	public function coursearrangedel()
	{
	    $data = Input::get('data');
	    $course = json_decode($data);

	    $dobj = Course::where('term', '=', $course->term)
            	    ->where('time', '=', $course->time)
            	    ->where('room', '=', $course->room)
            	    ->where('teacher', '=', $course->teacher)
            	    ->get();

	    foreach ($dobj as $d)
	    {
	        $d->delete();
	    }

	    return redirect(Input::get('returnurl'));
	}
	
	public static function getCourseForWeek($term, $teacher)
	{
	    $courseTable = array();
	    foreach (['一', '二', '三', '四', '五', '六', '日'] as $day)
	    {
	        foreach (['1,2', '3,4', '5,6', '7,8', '9,10,11'] as $class)
	        {
	            $courseTable['星期'.$day.'第'.$class.'节'] = ''; 
	        }
	    }

	    $courses = Course::where('teacher', '=', $teacher)
	                       ->where('cycle', '=',  '每周')
	                       ->where('term', '=',  $term)
	                       ->get();
	    
	    foreach ($courses as $course)
	    {
	        $courseTable[$course->time] = $course->course.' ('.$course->room.') '.$course->remarks;
	    }
	    
	    return $courseTable;
	}
}
