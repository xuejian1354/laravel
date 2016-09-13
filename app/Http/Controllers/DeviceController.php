<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;
use Illuminate\Support\Facades\Input;
use App\Record;
use Illuminate\Support\Facades\Auth;
use App\Action;

class DeviceController extends Controller
{
	public function index(Request $request) {

	}

	public function devCtrl(Request $request, $devsn) {
		$device = Device::where('sn', $devsn)->first();
		if(Input::get('data') == 1 && $device->data != '打开') {
			$device->data = '打开';
			$device->save();
			$this->addDevCtrlRecord($device);
		}
		elseif(Input::get('data') == 0 && $device->data != '关闭') {
			$device->data = '关闭';
			$device->save();
			$this->addDevCtrlRecord($device);
		}

		return $device->data;
	}

	public function addDevCtrlRecord($device) {

		$user = Auth::user();
		$action = Action::where('content', '控制')->first();

		Record::create([
				'sn' => Controller::getRandNum(),
				'content' => '"'.$user->name.'" 控制 "'.$device->name.'" '.$device->data,
				'usersn' => $user->sn,
				'action' => $action->id,
				'optnum' => Controller::getRandHex($user->email.$action->id.$device->sn.$device->data),
				'data' => null,
		]);
	}
}
