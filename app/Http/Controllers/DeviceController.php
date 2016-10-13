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
					$areaboxcontent->val = DeviceController::getIllumiFromArea($areasn);
					break;

				case 3: //大棚C02浓度
					$areaboxcontent->val = DeviceController::getDioxideFromArea($areasn);
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
					$areaboxcontent->val = DeviceController::getIllumiFromArea($areasn);
					break;

				case 14: //养猪场C02浓度
					$areaboxcontent->val = DeviceController::getDioxideFromArea($areasn);
					break;

				case 15: //养猪场氨气
					$areaboxcontent->val = DeviceController::getAmmoniaFromArea($areasn);
					break;

				case 16: //养猪场硫化氢
					$areaboxcontent->val = DeviceController::getHydrothionFromArea($areasn);
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

		$tempvals = array();
		$humivals = array();
		$devs = Device::where('area', $areasn)->where('type', 2)->get();
		
		foreach ($devs as $dev) {
			if($dev->data == null) {
				continue;
			}

			array_push($tempvals, hexdec(substr($dev->data, 0, 4))/100);
			array_push($humivals, hexdec(substr($dev->data, 4, 8))/100);
		}

		$temp = DeviceController::getAverageVal($tempvals);
		$humi = DeviceController::getAverageVal($humivals);

		$temp = ($temp == null ? '未知' : $temp.' ℃');
		$humi = ($humi == null ? '未知' : $humi.' %');

		return $temp.'/'.$humi;
	}

	//大棚土壤温度
	public static function getWarmhouseSoilTempFromArea($areasn) {
		$soiltemp = DeviceController::getDevAverageFromArea($areasn, 19);
		return $soiltemp == null ? '未知' : $soiltemp.'℃';
	}

	//大棚土壤水分
	public static function getWarmhouseSoilMoistureFromArea($areasn) {
		$soilmoisture = DeviceController::getDevAverageFromArea($areasn, 20, 'float');
		return $soilmoisture == null ? '未知' : $soilmoisture;
	}

	//大棚土壤PH值
	public static function getWarmhouseSoilPHFromArea($areasn) {
		$soilph = DeviceController::getDevAverageFromArea($areasn, 22, 'float');
		return $soilph == null ? '未知' : $soilph;
	}

	//大棚气象风速
	public static function getWarmhouseAirSpeedFromArea($areasn) {
		$speed = DeviceController::getDevAverageFromArea($areasn, 5, 'float');
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
		$dev = Device::where('area', $areasn)->where('type', 6)->first();
		if($dev == null || $dev->data == null) {
			return '未知';
		}
		else {
			return $dev->data;
		}
	}

	//大棚气象降雨量
	public static function getWarmhouseRainfallFromArea($areasn) {
		$rainfall = DeviceController::getDevAverageFromArea($areasn, 4);
		return $rainfall == null ? '未知' : $rainfall.'mm';
	}

	//大棚控制设备数
	public static function getWarmhouseDeviceNumsFromArea($areasn) {
		return Device::where('area', $areasn)->where('attr', '!=', 3)->count();
	}

	//养猪场温度
	public static function getHogpenTempFromArea($areasn) {
		$tempvals = array();
		$devs = Device::where('area', $areasn)->where('type', 2)->get();
		
		foreach ($devs as $dev) {
			if($dev->data == null) {
				continue;
			}

			array_push($tempvals, hexdec(substr($dev->data, 0, 4))/100);
		}

		$temp = DeviceController::getAverageVal($tempvals);
		return $temp == null ? '未知' : $temp.' ℃';
	}

	//养猪场湿度
	public static function getHogpenHumiFromArea($areasn) {
		$humivals = array();
		$devs = Device::where('area', $areasn)->where('type', 2)->get();
	
		foreach ($devs as $dev) {
			if($dev->data == null) {
				continue;
			}
	
			array_push($humivals, hexdec(substr($dev->data, 4, 8))/100);
		}
	
		$humi = DeviceController::getAverageVal($humivals);
	
		return $humi == null ? '未知' : $humi.' %';
	}

	//光照
	public static function getIllumiFromArea($areasn) {
		$devals = array();

		$devs = Device::where('area', $areasn)->where('type', 3)->get();
		foreach ($devs as $dev) {
			if($dev->data == null) {
				continue;
			}

			array_push($devals, hexdec(substr($dev->data, 0, 4)));
		}

		$illumi = DeviceController::getAverageVal($devals);
		return $illumi === null ? '未知' : round($illumi).' Lux';
	}

	//C02浓度
	public static function getDioxideFromArea($areasn) {
		$devals = array();

		$devs = Device::where('area', $areasn)->where('type', 13)->get();
		foreach ($devs as $dev) {
			if($dev->data == null) {
				continue;
			}

			array_push($devals, hexdec(substr($dev->data, 0, 4)));
		}

		$dioxide = DeviceController::getAverageVal($devals);		
		return $dioxide === null ? '未知' : $dioxide.' ppm';
	}

	//氨气
	public static function getAmmoniaFromArea($areasn) {
		$devals = array();

		$devs = Device::where('area', $areasn)->where('type', 7)->get();
		foreach ($devs as $dev) {
			if($dev->data == null) {
				continue;
			}

			array_push($devals, hexdec(substr($dev->data, 0, 4)));
		}

		$ammonia = DeviceController::getAverageVal($devals);		
		return $ammonia === null ? '未知' : $ammonia.' ppm';
	}

	//硫化氢
	public static function getHydrothionFromArea($areasn) {
		$devals = array();

		$devs = Device::where('area', $areasn)->where('type', 9)->get();
		foreach ($devs as $dev) {
			if($dev->data == null) {
				continue;
			}

			array_push($devals, hexdec(substr($dev->data, 0, 4)));
		}

		$dydrothion = DeviceController::getAverageVal($devals);		
		return $dydrothion === null ? '未知' : $dydrothion.' ppm';
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

	public function devSetting(Request $request) {
		$devsettings = json_decode($request->get('devs'));
		foreach ($devsettings as $devsetting) {
			$dev = Device::where('sn', $devsetting->sn)->first();
			if($dev != null) {
				$dev->name = trim($devsetting->name);
				$dev->type = $devsetting->type;
				$dev->attr = $dev->rel_type->attr;
				$dev->area = $devsetting->area;
				$dev->save();

				$devsetting->updated_at = ComputeController::getTimeFlag($dev->updated_at);
			}
		}

		return json_encode($devsettings);
	}

	public function devCtrl(Request $request, $devsn) {
		$device = Device::where('sn', $devsn)->first();
		$update_at = strtotime($device->updated_at);
		if(Input::get('data') == 1 && $device->data != '打开') {
			$device->data = '打开';
			$update_at = (new DevDataEvent($device->sn, $device->data))->updateToPusher();
		}
		elseif(Input::get('data') == 0 && $device->data != '关闭') {
			$device->data = '关闭';
			$update_at = (new DevDataEvent($device->sn, $device->data))->updateToPusher();
		}

		return [$device->data, date('H:i:s', $update_at)];
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
