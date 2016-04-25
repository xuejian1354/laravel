<?php namespace App\Http\Controllers\Admin;

use Input, DB;
use App\Model\Hardware\Device;
use App\Model\DBStatic\Devtype;
use App\Model\Room\Room;
use App\Model\DBStatic\Roomtype;
use App\Model\DBStatic\Roomaddr;
use App\Http\Controllers\ExcelController;
use App\User;
use App\Http\Controllers\Controller;

class AdminRoom {

	protected $menus;

	protected $rooms;
	protected $roomtypestr;
	protected $roomaddrstr;
	protected $userstr;
	protected $ownerstr;

	public function __construct($menus)
	{
		$this->menus = $menus;
	}

	public function getRoomView()
	{
		if($this->menus->getAmenu()['caction'] == 'opt')
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
						return AdminController::getViewWithMenus('admin.admin')
									->withRoom($room[0])
									->withGlobalvals(Controller::getGlobalvals())
									->withDevcmds($devcmds)
									->withDevices($devargs);
					}
					else
					{
						return '<script type="text/javascript">window.location.replace("/admin?action=roomctrl");alert("该教室中没有设备");</script>';
					}
				}
			}
		
			return $this->backView('未找到教室');
		}
		
		$this->rooms = Room::all();
		foreach ($this->rooms as $room)
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
		
		$this->roomtypestr = array();
		foreach(Roomtype::all() as $roomtype)
		{
			array_push($this->roomtypestr, $roomtype->val.'('.$roomtype->roomtype.')');
		}
		//sort($roomtypestr);
		
		$this->roomaddrstr = array();
		foreach(Roomaddr::all() as $roomaddr)
		{
			array_push($this->roomaddrstr, $roomaddr->val.'('.$roomaddr->roomaddr.')');
		}
		//sort($roomaddrstr);
		
		$this->userstr = array();
		$this->ownerstr = array();
		foreach(User::all() as $user)
		{
			if($user->privilege >= 4)
			{
				array_push($this->userstr, $user->name);
			}
		
			if($user->privilege >= 5)
			{
				array_push($this->ownerstr, $user->name);
			}
		}
		sort($this->userstr);
		sort($this->ownerstr);

		return AdminController::getViewWithMenus('admin.admin')
					->withRooms($this->rooms)
					->withRoomtypes($this->roomtypestr)
					->withRoomtypestr(json_encode($this->roomtypestr))
					->withRoomaddrs($this->roomaddrstr)
					->withRoomaddrstr(json_encode($this->roomaddrstr))
					->withUsers($this->userstr)
					->withUserstr(json_encode($this->userstr))
					->withOwners($this->ownerstr)
					->withOwnerstr(json_encode($this->ownerstr));
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
}
