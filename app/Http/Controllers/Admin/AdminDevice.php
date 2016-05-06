<?php namespace App\Http\Controllers\Admin;

use Input, Auth;
use App\User;
use App\Model\Hardware\Gateway;
use App\Model\Hardware\Device;
use App\Model\DBStatic\Privilege;
use App\Model\DBStatic\Devtype;
use App\Model\DBStatic\Devcmd;
use App\Model\Room\Room;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PageTag;

class AdminDevice {

	protected $menus;

	protected $gwargs;
	protected $devargs;

	protected $gwPagetag;
	protected $devPagetag;

	public function __construct($menus)
	{
		$this->menus = $menus;

		$gateways = Gateway::all();
		$devices = Device::all();

		$pagetag = new PageTag(8, 5, count($gateways), $this->menus->getPage());
		if($pagetag->isAvaliable())
		{
		    $gateways = Gateway::paginate($pagetag->getRow());
		}
		$this->gwPagetag = $pagetag;

		$pagetag = new PageTag(8, 5, count($devices), $this->menus->getPage());
		if($pagetag->isAvaliable())
		{
		    $devices = Device::paginate($pagetag->getRow());
		}
		$this->devPagetag = $pagetag;

		$devtypes = Devtype::all();
		$devcmds = Controller::getDevCmds();
		$this->gwargs = array();
		$this->devargs = array();

		foreach ($gateways as $gateway)
		{
			if($this->menus->getAmenu()['caction'] == 'gwedit' && isset($_GET['id']) && $gateway->id != Input::get('id'))
			{}
			else
			{
				array_push($this->gwargs, $gateway);
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

			if(($this->menus->getAmenu()['caction'] == 'devedit'
					&& isset($_GET['id']) && $device->id != Input::get('id'))
				|| ($this->menus->getAmenu()['caction'] == 'async'
					&& isset($_GET['area']) && $device->area != Input::get('area')))
			{}
			else
			{
				array_push($this->devargs, $device);
			}
		}
	}

	public function getDeviceView()
	{
		if(Auth::user()->grade == 1 || Auth::user()->privilege == 5)
		{
			$room = null;
			if($this->menus->getAmenu()['caction'] == 'async')
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

				return AdminController::getViewWithMenus($async)
							->withRoom($room[0])
							->withDevcmds($devcmds)
							->withUsers(User::all())
							->withGwpagetag($this->gwPagetag)
							->withDevpagetag($this->devPagetag)
							->withGateways($this->gwargs)
							->withDevices($this->devargs);
			}
			else
			{
				return AdminController::getViewWithMenus('admin.admin')
							->withDevcmds(Controller::getDevCmds())
							->withAreas(Room::all())
							->withUsers(User::all())
							->withGwpagetag($this->gwPagetag)
							->withDevpagetag($this->devPagetag)
							->withGateways($this->gwargs)
							->withDevices($this->devargs);
			}
		}
		else
		{
			return view('errors.permitts');
		}
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
}
