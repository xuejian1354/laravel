<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Device;
use App\Record;
use App\Action;
use App\Areaboxcontent;

class DeviceController extends Controller
{
	public function index(Request $request) {

	}

	private static function updateAreaboxDBByContentType($areasn, $type) {
		$areaboxcontent = Areaboxcontent::where('area_sn', $areasn)->where('type', $type)->first();
		if($areaboxcontent != null) {
			switch ($type) {
				case 1: //温湿度
					$areaboxcontent->val = DeviceController::getHumiTempFromArea($areasn);
					break;

				case 2: //光照
					$areaboxcontent->val = DeviceController::getIllumiFromArea($areasn);
					break;

				case 3: //C02浓度
					$areaboxcontent->val = DeviceController::getDioxideFromArea($areasn);
					break;

				case 4: //土壤温度
					$areaboxcontent->val = DeviceController::getSoilTempFromArea($areasn);
					break;

				case 5: //土壤水分
					$areaboxcontent->val = DeviceController::getSoilMoistureFromArea($areasn);
					break;

				case 6: //土壤PH值
					$areaboxcontent->val = DeviceController::getSoilPHFromArea($areasn);
					break;

				case 7: //气象风速
					$areaboxcontent->val = DeviceController::getAirSpeedFromArea($areasn);
					break;

				case 8: //气象风向
					$areaboxcontent->val = DeviceController::getAirDirectionFromArea($areasn);
					break;

				case 9: //气象降雨量
					$areaboxcontent->val = DeviceController::getRainfallFromArea($areasn);
					break;

				case 10: //控制设备数
					$areaboxcontent->val = DeviceController::getDeviceNumsFromArea($areasn);
					break;
			}

			$areaboxcontent->save();
			return [$areaboxcontent->id => $areaboxcontent->val];
		}

		return null;
	}

	public static function updateAreaboxDB($areasn, $type = null) {

		if($type == null) {
			$rets = array();
			for ($i=1; $i<=10; $i++) {
				$ret = DeviceController::updateAreaboxDBByContentType($areasn, $i);
				if($ret != null) {
					foreach ($ret as $k => $v) {
						$rets[$k] = $v;
					}
				}
			}

			return $rets;
		}
		else {
			return DeviceController::updateAreaboxDBByContentType($areasn, $type);
		}
	}

	public static function getHumiTempFromArea($areasn) {
		$temp = DeviceController::getDevAverageFromArea($areasn, 2);
		$temp = ($temp == null ? '未知' : round($temp).'℃');

		$humi = DeviceController::getDevAverageFromArea($areasn, 3);
		$humi = ($humi == null ? '未知' : $humi.'%');

		return $temp.'/'.$humi;
	}

	public static function getIllumiFromArea($areasn) {
		$illumi = DeviceController::getDevAverageFromArea($areasn, 4);
		return $illumi == null ? '未知' : round($illumi).' Lux';
	}

	public static function getDioxideFromArea($areasn) {
		$dioxide = DeviceController::getDevAverageFromArea($areasn, 14, 'float');
		return $dioxide == null ? '未知' : $dioxide.'%';
	}

	public static function getSoilTempFromArea($areasn) {
		$soiltemp = DeviceController::getDevAverageFromArea($areasn, 20);
		return $soiltemp == null ? '未知' : $soiltemp.'℃';
	}

	public static function getSoilMoistureFromArea($areasn) {
		$soilmoisture = DeviceController::getDevAverageFromArea($areasn, 21, 'float');
		return $soilmoisture == null ? '未知' : $soilmoisture;
	}

	public static function getSoilPHFromArea($areasn) {
		$soilph = DeviceController::getDevAverageFromArea($areasn, 23, 'float');
		return $soilph == null ? '未知' : $soilph;
	}

	public static function getAirSpeedFromArea($areasn) {
		$speed = DeviceController::getDevAverageFromArea($areasn, 6, 'float');
		if($speed == null) {
			return '未知';
		}

		if(floor($speed) < ceil($speed)) {
			return '&lt; '.ceil($speed).' 级';
		}
		else {
			return $speed.' 级';
		}
	}

	public static function getAirDirectionFromArea($areasn) {
		$dev = Device::where('area', $areasn)->where('type', 7)->first();
		if($dev == null || $dev->data == null) {
			return '未知';
		}
		else {
			return $dev->data;
		}
	}

	public static function getRainfallFromArea($areasn) {
		$rainfall = DeviceController::getDevAverageFromArea($areasn, 5);
		return $rainfall == null ? '未知' : $rainfall.'mm';
	}

	public static function getDeviceNumsFromArea($areasn) {
		return Device::where('area', $areasn)->count();
	}

	public static function getDevAverageFromArea($areasn, $opttype, $ol = 'int') {
		$devals = array();
		$devs = Device::where('area', $areasn)->where('type', $opttype)->get();

		foreach ($devs as $dev) {
			if($dev->data == null) {
				continue;
			}

			if($ol == 'int') {
				array_push($devals, (int)$dev->data);
			}
			else if($ol == 'float') {
				array_push($devals, (float)$dev->data);
			}
			else {
				array_push($devals, $dev->data);
			}
		}

		return DeviceController::getAverageVal($devals);
	}

	public static function getAverageVal(array $tovals) {

		if(count($tovals) == 0) {
			return null;
		}

		$sum = 0;
		$count = count($tovals);
		sort($tovals);

		if($count > 3) {
			$tovals = array_splice($tovals, 1, -1);
			$count -= 2;
		}

		foreach ($tovals as $toval) {
			if($toval == 0) {
				continue;
			}

			$sum += $toval;
		}

		$count == 0 && $count = 1;

		return $sum/$count;
	}

	public function devCtrl(Request $request, $devsn) {
		$device = Device::where('sn', $devsn)->first();
		if(Input::get('data') == 1 && $device->data != '打开') {
			$device->data = '打开';
			$device->save();
			DeviceController::addDevCtrlRecord($device);
		}
		elseif(Input::get('data') == 0 && $device->data != '关闭') {
			$device->data = '关闭';
			$device->save();
			DeviceController::addDevCtrlRecord($device);
		}

		return [$device->data, date('H:i:s', strtotime($device->updated_at))];
	}

	public static function addDevCtrlRecord($device) {

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
