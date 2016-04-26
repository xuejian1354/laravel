<?php namespace App\Http\Controllers\Admin;

use Input, Auth, DB;
use App\User;
use App\Http\Controllers\Controller;
use App\Model\DBStatic\News;
use App\Model\DBStatic\Academy;
use App\Model\DBStatic\Classgrade;
use App\Model\DBStatic\Userdetail;
use App\Model\DBStatic\Grade;

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
				$news = DB::select('SELECT * FROM news ORDER BY updated_at DESC');
				$enews = array();
				foreach ($news as $anew)
				{
					$this->addAllowTextToNews($anew);

					$opt = Input::get('opt');
					if($opt == 'all')
					{
						$newsid = Input::get('newsid');
						if($newsid != null && $newsid == $anew->id)
						{
							return view('admin.userinfo.newscontent')
										->withReturnurl('admin?action=useractivity&id='.Input::get('id').'&tabpos='.Input::get('tabpos'))
										->withNews($anew);
						}
						continue;
					}

					if(strlen($anew->text) > 600)
					{
						$anew->text = substr($anew->text, 0, 600).' ...';
					}

					if($anew->owner == $user->name)
					{
						$anew->isrecv = false;
						array_push($enews, $anew);
					}
					else
					{
						$anew->isrecv = true;

						$userdetail = DB::table('userdetails')->where('sn', $user->sn)->get();
						if($userdetail != null)
						{
							$userdetail = $userdetail[0];
						}

						switch($anew->allowgrade)
						{
						case 1: //school
							array_push($enews, $anew);
							break;
						
						case 2: //academy
							if($userdetail == null)
							{
								break;
							}

							if($userdetail->grade == 1)	//administrator
							{
								array_push($enews, $anew);
							}
							else if($userdetail->grade == 2) //teacher
							{
								if($anew->visitor == $userdetail->type)
								{
									array_push($enews, $anew);
								}
							}
							else if($userdetail->grade == 3) //student
							{
								$classgrade = DB::table('classgrades')->where('classgrade', $userdetail->type)->get();
								if($classgrade != null)
								{
									$classgrade = $classgrade[0];
									if($anew->visitor == $classgrade->academy)
									{
										array_push($enews, $anew);
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
								array_push($enews, $anew);
							}
							else if($userdetail->grade == 2) //teacher
							{
								$classgrade = DB::table('classgrades')->where('classgrade', $anew->visitor)->get();
								if($classgrade != null)
								{
									$classgrade = $classgrade[0];
									if($classgrade->academy == $userdetail->type)
									{
										array_push($enews, $anew);
									}
								}
							}
							else if($userdetail->grade == 3) //student
							{
								if($anew->visitor == $userdetail->type)
								{
									array_push($enews, $anew);
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
									array_push($enews, $anew);
									break;
								}
							}

							if($userdetail != null)
							{
								if($userdetail->grade == 1)	//administrator
								{
									array_push($enews, $anew);
								}
								else if($anew->visitor == $user->name)
								{
									array_push($enews, $anew);
								}
							}
							break;
						}
					}
				}

				return AdminController::getViewWithMenus('admin.admin')
							->withNews($enews)
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

				return AdminController::getViewWithMenus('admin.admin')
							->withUserdetail($userdetail)
							->withAcademies(Academy::all())
							->withClassgrades(Classgrade::all())
							->withUser($user);
			}

			return AdminController::getViewWithMenus('admin.admin')
						->withUser($user);
		}
		else
		{
			return view('errors.permitts');
		}
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
}
