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
				case 1: //大棚温湿度
					$areaboxcontent->val = DeviceController::getWarmhouseHumiTempFromArea($areasn);
					break;

				case 2: //大棚光照
					$areaboxcontent->val = DeviceController::getWarmhouseIllumiFromArea($areasn);
					break;

				case 3: //大棚C02浓度
					$areaboxcontent->val = DeviceController::getWarmhouseDioxideFromArea($areasn);
					break;

				case 4: //大棚土壤温度
					$areaboxcontent->val = DeviceController::getWarmhouseSoilTempFromArea($areasn);
					break;

				case 5: //大棚土壤水分
					$areaboxcontent->val = DeviceController::getWarmhouseSoilMoistureFromArea($areasn);
					break;

				case 6: //大棚土壤PH值
					$areaboxcontent->val = DeviceController::getWarmhouseSoilPHFromArea($areasn);
					break;

				case 7: //大棚气象风速
					$areaboxcontent->val = DeviceController::getWarmhouseAirSpeedFromArea($areasn);
					break;

				case 8: //大棚气象风向
					$areaboxcontent->val = DeviceController::getWarmhouseAirDirectionFromArea($areasn);
					break;

				case 9: //大棚气象降雨量
					$areaboxcontent->val = DeviceController::getWarmhouseRainfallFromArea($areasn);
					break;

				case 10: //大棚控制设备数
					$areaboxcontent->val = DeviceController::getWarmhouseDeviceNumsFromArea($areasn);
					break;

				case 11: //养猪场温度
					$areaboxcontent->val = DeviceController::getHogpenTempFromArea($areasn);
					break;

				case 12: //养猪场湿度
					$areaboxcontent->val = DeviceController::getHogpenHumiFromArea($areasn);
					break;

				case 13: //养猪场光照
					$areaboxcontent->val = DeviceController::getHogpenIllumiFromArea($areasn);
					break;

				case 14: //养猪场C02浓度
					$areaboxcontent->val = DeviceController::getHogpenDioxideFromArea($areasn);
					break;

				case 15: //养猪场氨气
					$areaboxcontent->val = DeviceController::getHogpenAmmoniaFromArea($areasn);
					break;

				case 16: //养猪场硫化氢
					$areaboxcontent->val = DeviceController::getHogpenHydrothionFromArea($areasn);
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
			for ($i=1; $i<=16; $i++) {
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

	//大棚温湿度
	public static function getWarmhouseHumiTempFromArea($areasn) {
		$temp = DeviceController::getDevAverageFromArea($areasn, 2);
		$temp = ($temp == null ? '未知' : round($temp).'℃');

		$humi = DeviceController::getDevAverageFromArea($areasn, 3);
		$humi = ($humi == null ? '未知' : $humi.'%');

		return $temp.'/'.$humi;
	}

	//大棚光照
	public static function getWarmhouseIllumiFromArea($areasn) {
		$illumi = DeviceController::getDevAverageFromArea($areasn, 4);
		return $illumi == null ? '未知' : round($illumi).' Lux';
	}

	//大棚C02浓度
	public static function getWarmhouseDioxideFromArea($areasn) {
		$dioxide = DeviceController::getDevAverageFromArea($areasn, 14, 'float');
		return $dioxide == null ? '未知' : $dioxide.'%';
	}

	//大棚土壤温度
	public static function getWarmhouseSoilTempFromArea($areasn) {
		$soiltemp = DeviceController::getDevAverageFromArea($areasn, 20);
		return $soiltemp == null ? '未知' : $soiltemp.'℃';
	}

	//大棚土壤水分
	public static function getWarmhouseSoilMoistureFromArea($areasn) {
		$soilmoisture = DeviceController::getDevAverageFromArea($areasn, 21, 'float');
		return $soilmoisture == null ? '未知' : $soilmoisture;
	}

	//大棚土壤PH值
	public static function getWarmhouseSoilPHFromArea($areasn) {
		$soilph = DeviceController::getDevAverageFromArea($areasn, 23, 'float');
		return $soilph == null ? '未知' : $soilph;
	}

	//大棚气象风速
	public static function getWarmhouseAirSpeedFromArea($areasn) {
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

	//大棚气象风向
	public static function getWarmhouseAirDirectionFromArea($areasn) {
		$dev = Device::where('area', $areasn)->where('type', 7)->first();
		if($dev == null || $dev->data == null) {
			return '未知';
		}
		else {
			return $dev->data;
		}
	}

	//大棚气象降雨量
	public static function getWarmhouseRainfallFromArea($areasn) {
		$rainfall = DeviceController::getDevAverageFromArea($areasn, 5);
		return $rainfall == null ? '未知' : $rainfall.'mm';
	}

	//大棚控制设备数
	public static function getWarmhouseDeviceNumsFromArea($areasn) {
		return Device::where('area', $areasn)->where('attr', '!=', 3)->count();
	}

	//养猪场温度
	public static function getHogpenTempFromArea($areasn) {
		$temp = DeviceController::getDevAverageFromArea($areasn, 2);
		$temp = ($temp == null ? '未知' : round($temp).'℃');

		return $temp;
	}

	//养猪场湿度
	public static function getHogpenHumiFromArea($areasn) {
		$humi = DeviceController::getDevAverageFromArea($areasn, 3);
		$humi = ($humi == null ? '未知' : $humi.'%');

		return $humi;
	}

	//养猪场光照
	public static function getHogpenIllumiFromArea($areasn) {
		$illumi = DeviceController::getDevAverageFromArea($areasn, 4);
		return $illumi == null ? '未知' : round($illumi).' Lux';
	}

	//养猪场C02浓度
	public static function getHogpenDioxideFromArea($areasn) {
		$dioxide = DeviceController::getDevAverageFromArea($areasn, 14, 'float');
		return $dioxide == null ? '未知' : $dioxide.'%';
	}

	//养猪场氨气
	public static function getHogpenAmmoniaFromArea($areasn) {
		$ammonia = DeviceController::getDevAverageFromArea($areasn, 8, 'float');
		return $ammonia == null ? '未知' : $ammonia.'%';
	}

	//养猪场硫化氢
	public static function getHogpenHydrothionFromArea($areasn) {
		$hydrothion = DeviceController::getDevAverageFromArea($areasn, 10, 'float');
		return 
		$hydrothion == null ? '未知' : $hydrothion.'%';
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
			(new DevDataEvent($device->sn, $device->data))->updateToPusher();
		}
		elseif(Input::get('data') == 0 && $device->data != '关闭') {
			$device->data = '关闭';
			(new DevDataEvent($device->sn, $device->data))->updateToPusher();
		}

		//return [$device->data, date('H:i:s', strtotime($device->updated_at))];
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
