<?php namespace App\Http\Controllers\Admin;

use Input, Auth, DB;
use App\User;
use App\Model\DBStatic\Grade;
use App\Model\DBStatic\News;
use App\Model\DBStatic\Idgrade;
use App\Model\DBStatic\Academy;
use App\Model\DBStatic\Classgrade;
use App\Http\Controllers\PageTag;
use App\Model\DBStatic\Userrecord;

class AdminUserInfo {

	protected $menus;

	public function __construct($menus)
	{
		$this->menus = $menus;
	}

	public function getUserView()
	{
		if(Auth::user()->grade == 1 || Auth::user()->privilege == 5)
		{
			if($this->menus->getAmenu()['caction'] == 'newscontent')
			{
				$news = News::find(Input::get('id'));

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
				

				return view('admin.userinfo.newscontent')
							->withNews($news);
			}
			else if($this->menus->getAmenu()['caction'] == 'addnews')
			{
				return view('admin.userinfo.addnews')
						->withIdgrades(Idgrade::all())
						->withAcademies(Academy::all())
						->withclassgrades(Classgrade::all())
						->withUsers(User::all());
			}
			else if($this->menus->getAmenu()['caction'] == 'newsedts')
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
			else if($this->menus->getAmenu()['caction'] == 'addacademy')
			{
				$users = DB::select('SELECT * FROM users where grade<=\'2\'');
				return view('admin.userinfo.addacademy')
							->withUsers($users);
			}
			else if($this->menus->getAmenu()['caction'] == 'academyedt')
			{
				$academy = Academy::find(Input::get('id'));
				$users = DB::select('SELECT * FROM users where grade<=\'2\'');
				return view('admin.userinfo.academyedt')
							->withAcademy($academy)
							->withUsers($users);
			}
			else if($this->menus->getAmenu()['caction'] == 'addclassgrade')
			{
				return view('admin.userinfo.addclassgrade')
							->withAcademies(Academy::all())
							->withUsers(User::all());
			}
			else if($this->menus->getAmenu()['caction'] == 'classgradeedt')
			{
				$classgrade = Classgrade::find(Input::get('id'));
				return view('admin.userinfo.classgradeedt')
							->withClassgrade($classgrade)
							->withAcademies(Academy::all())
							->withUsers(User::all());
			}

			//$news = News::all();
			$news = DB::select('SELECT * FROM news ORDER BY updated_at DESC');
			$pagetag = new PageTag(8, 5, count($news), $this->menus->getPage());
			if($pagetag->isAvaliable())
			{
			    if(Input::get('tabpos') == 0)
			    {
	       		    $news = News::paginate($pagetag->getRow());
			    }
			    else
			    {
			        $news = News::paginate($pagetag->getRow(), ['*'], 'page', 1);
			        $pagetag->setPage(1);
			    }
			}
			$newspagetag = $pagetag;

			foreach ($news as $new)
			{
				if(strlen($new->subtitle) > 81)
				{
					$new->subtitle = mb_substr($new->subtitle, 0, 27, 'utf-8').' ...';
				}

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
			$pagetag = new PageTag(8, 5, $classgrades->count(), $this->menus->getPage());
			if($pagetag->isAvaliable())
			{
			    if(Input::get('tabpos') == 2)
			    {
			        $classgrades = Classgrade::paginate($pagetag->getRow());
			    }
			    else
			    {
			        $classgrades = Classgrade::paginate($pagetag->getRow(), ['*'], 'page', 1);
			        $pagetag->setPage(1);
			    }
			}
			$classgradepagetag = $pagetag;

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

			$academies = Academy::all();
			$pagetag = new PageTag(8, 5, $academies->count(), $this->menus->getPage());
			if($pagetag->isAvaliable())
			{
			    if(Input::get('tabpos') == 1)
			    {
			        $academies = Academy::paginate($pagetag->getRow());
			    }
			    else
			    {
			        $academies = Academy::paginate($pagetag->getRow(), ['*'], 'page', 1);
			        $pagetag->setPage(1);
			    }
			}
			$academypagetag = $pagetag;

			return AdminController::getViewWithMenus('admin.admin')
			            ->withNewspagetag($newspagetag)
			            ->withAcademypagetag($academypagetag)
			            ->withClassgradepagetag($classgradepagetag)
						->withNews($news)
						->withAcademies($academies)
						->withClassgrades($classgrades)
						->withGrades(Grade::all());
		}
		else
		{
			return view('errors.permitts');
		}
	}

	public function addnews()
	{
		$user = User::find(Input::get('optid'));

		if(($user!= null && $user->grade == 4)
			|| ($user != null && $user->privilege == 1)
			|| Auth::user()->grade == 4
			|| Auth::user()->privilege == 1)
		{
			return view('errors.permitts');
		}

		$content = array();
		$title = Input::get('title');
		if($title == null)
		{
			return AdminController::backView("标题不能为空");
		}

		$content['sn'] = $this->genNewsSN($title);
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

		$owner = Input::get('newsowner');
		if($owner != null)
		{
			$content['owner'] = $owner;
		}
		else
		{
			$content['owner'] = Auth::user()->name;
		}

		$text = Input::get('text');
		if($text != null)
		{
			$content['text'] = $text;
		}
	
		News::create($content);
	
		$returnurl = Input::get('returnurl');
		if($returnurl != null)
		{
		    if(Input::get('adminflag') == 1)
		    {
		        $returnurl .= '&adminmenus=1';
		    }
			return redirect($returnurl);
		}

		return redirect("admin?action=userinfo&tabpos=0");
	}

	public function newsdel(){
		$data = json_decode(Input::get('data'));
		foreach ($data as $id)
		{
			if(Auth::user()->grade == 4
				|| Auth::user()->privilege == 1
				|| (News::find($id)->owner != Auth::user()->name
					&& Auth::user()->grade != 1 && Auth::user()->privilege != 5))
			{
				return view('errors.permitts');
			}
		}

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
			$user = User::find(Input::get('optid'.$new->id));

			if(($user!= null && $user->grade == 4)
				|| ($user != null && $user->privilege == 1)
				|| Auth::user()->grade == 4
				|| Auth::user()->privilege == 1
				|| ($new->owner != Auth::user()->name
					&& Auth::user()->grade != 1 
					&& Auth::user()->privilege != 5))
			{
				return view('errors.permitts');
			}
		}

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

			$owner = Input::get('newsowner'.$newsids[$index]);
			if($owner != null)
			{
				$new->owner = $owner;
			}
			else
			{
				$new->owner = Auth::user()->name;
			}

			$text = Input::get('text'.$newsids[$index]);
			if($text != null)
			{
				$new->text = $text;
			}

			$new->save();

			foreach(Userrecord::where('optnum', '=', $new->sn)->get() as $record)
			{
			    $record->delete();
			}
		}

		$returnurl = Input::get('returnurl');
		if($returnurl != null)
		{
		    if(Input::get('adminflag') == 1)
		    {
		        $returnurl .= '&adminmenus=1';
		    }
			return redirect($returnurl);
		}

		return redirect("admin?action=userinfo&tabpos=0");
	}

	public function academydel(){
		$data = json_decode(Input::get('data'));
		foreach ($data as $id)
		{
			Academy::find($id)->delete();
		}

		return redirect("admin?action=userinfo&tabpos=1");
	}

	public function addacademy()
	{
		$content = array();
		$val = Input::get('val');
		if($val == null)
		{
			return $this->backView("学院不能为空");
		}

		$academyId = 1;
		foreach(Academy::all() as $academy)
		{
			$academyId = max([$academyId, $academy->academy]);
		}
		$academyId++;

		$content['academy'] = $academyId;
		$content['val'] = $val;
	
		$academyteacher = Input::get('academyteacher');
		if($academyteacher != null)
		{
			$content['academyteacher'] = $academyteacher;
		}

		$otherteachers = Input::get('otherteachers');
		if($otherteachers != null)
		{
			$content['otherteachers'] = $otherteachers;
		}

		$text = Input::get('text');
		if($text != null)
		{
			$content['text'] = $text;
		}

		Academy::create($content);

		return redirect("admin?action=userinfo&tabpos=1");
	}

	public function academyedt()
	{
		$academy = Academy::find(Input::get('id'));

		$val = Input::get('val');
		if($val != null)
		{
			$academy->val = $val;
		}

		$academyteacher = Input::get('academyteacher');
		if($academyteacher != null)
		{
			$academy->academyteacher = $academyteacher;
		}

		$otherteachers = Input::get('otherteachers');
		if($otherteachers != null)
		{
			$academy->otherteachers = $otherteachers;
		}

		$text = Input::get('text');
		if($text != null)
		{
			$academy->text = $text;
		}

		$academy->save();

		return redirect("admin?action=userinfo&tabpos=1");
	}

	public function classgradedel(){
		$data = json_decode(Input::get('data'));
		foreach ($data as $id)
		{
			Classgrade::find($id)->delete();
		}

		return redirect("admin?action=userinfo&tabpos=2");
	}

	public function addclassgrade()
	{
		$content = array();
		$val = Input::get('val');
		if($val == null)
		{
			return $this->backView("班级不能为空");
		}

		$classgradeId = 1;
		foreach(Classgrade::all() as $classgrade)
		{
			$classgradeId = max([$classgradeId, $classgrade->classgrade]);
		}
		$classgradeId++;
	
		$content['classgrade'] = $classgradeId;
		$content['val'] = $val;

		$ga = Input::get('academy');
		if($ga != null)
		{
			foreach (Academy::all() as $academy)
			{
				if($academy->val == $ga)
				{
					$content['academy'] = $academy->academy;
					break;
				}
			}
		}

		$classteacher = Input::get('classteacher');
		if($classteacher != null)
		{
			$content['classteacher'] = $classteacher;
		}

		$assistant = Input::get('assistant');
		if($assistant != null)
		{
			$content['assistant'] = $assistant;
		}

		$leader = Input::get('leader');
		if($leader != null)
		{
			$content['leader'] = $leader;
		}

		$text = Input::get('text');
		if($text != null)
		{
			$content['text'] = $text;
		}

		Classgrade::create($content);

		return redirect("admin?action=userinfo&tabpos=2");
	}

	public function classgradeedt()
	{
		$classgrade = Classgrade::find(Input::get('id'));

		$val = Input::get('val');
		if($val != null)
		{
			$classgrade->val = $val;
		}

		$ga = Input::get('academy');
		if($ga != null)
		{
			foreach (Academy::all() as $academy)
			{
				if($academy->val == $ga)
				{
					$classgrade->academy = $academy->academy;
					break;
				}
			}
		}

		$classteacher = Input::get('classteacher');
		if($classteacher != null)
		{
			$classgrade->classteacher = $classteacher;
		}

		$assistant = Input::get('assistant');
		if($assistant != null)
		{
			$classgrade->assistant = $assistant;
		}

		$leader = Input::get('leader');
		if($leader != null)
		{
			$classgrade->leader = $leader;
		}

		$text = Input::get('text');
		if($text != null)
		{
			$classgrade->text = $text;
		}

		$classgrade->save();

		return redirect("admin?action=userinfo&tabpos=2");
	}

	public static  function genNewsSN($title)
	{
		$ran = rand(1, 1000000);
		$sn = substr(hexdec(md5($title.$ran)), 2, 8);
	
		return $sn;
	}
}
