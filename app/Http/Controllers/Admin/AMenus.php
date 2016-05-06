<?php namespace App\Http\Controllers\Admin;

use Input;
use App\Model\DBStatic\Consolemenu;

class AMenus {

	protected $amenu = '#';
	protected $menus;
	protected $nmenus;
	protected $page = 0;
	
	public function __construct($actions = null)
	{
		//$action = isset($_GET['action'])?$_GET['action']:"#";
		if($actions == null)
		{
			$actions = explode('/', Input::get('action'));
		}
		else
		{
			$actions = explode('/', $actions);
		}
		
		$gp = Input::get('page');
		if($gp != null)
		{
		    $this->page = $gp;
		}
		else
		{
		    $this->page = 1;
		}

		$this->menus = Consolemenu::all();
		$mmenus = array();

		foreach ($this->menus as $menu)
		{
			if($actions[0] == $menu->action
				|| ($actions[0] == 'setting' && $menu->mmenu == '设置')
				|| ($actions[0] == 'userfunc' && $menu->mmenu == '功能'))
			{
				if($this->amenu == "#")
				{
					$this->amenu = $menu;
					$this->amenu['caction'] = $menu->action;
				}
			}
			array_push($mmenus, $menu->mmenu);
		}

		if($this->amenu == "#")
		{
			$this->amenu = $this->menus[0];
			$this->amenu['caction'] = $this->menus[0]->action;
		}

		if(isset($actions[1]))
		{
			$this->amenu['caction'] = $actions[1];
		}

		$umenus = array_unique($mmenus);
		$this->nmenus = array();
		foreach($umenus as $umenu)
		{
			foreach ($this->menus as $menu)
			{
				if ($umenu == $menu->mmenu)
				{
					array_push($this->nmenus, $menu);
					break;
				}
			}
		}
	}

	public function getAmenu()
	{
		return $this->amenu;
	}

	public function getMenus()
	{
		return $this->menus;
	}

	public function getNmenus()
	{
		return $this->nmenus;
	}
	
	public function getPage()
	{
	    return $this->page;
	}
}
