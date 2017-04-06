<?php

namespace App\Http\Controllers\CulliveBefore;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Model\Device;
use App\Model\Ctrlrecord;
use App\Model\Action;
use App\Model\Areaboxcontent;
use App\Model\Globalval;
use App\User;
use App\Http\Controllers\Controller;

class DeviceController extends Controller
{
	public function index(Request $request) {

	}

	public static function getDevtypeFromBoxtype($type) {
		$arr = [1 => 2, 2 => 3, 3 => 13, 4 => 19, 5 => 20, 6 => 22,
		        7 => 5, 8 => 6, 9 => 4, 10 => null, 11 => 2, 12 => 2, 13 => 3,
		        14 => 13, 15 => 7, 16 => 9];

		return $arr[$type];
	}

	private static function updateAreaboxDBByContentType($areasn, $type) {
		$areaboxcontent = Areaboxcontent::where('area_sn', $areasn)->where('type', $type)->first();
		if($areaboxcontent != null) {
			switch ($type) {
				case 1: //大棚温湿度
					$areaboxcontent->val = DeviceController::getWarmhouseHumiTempFromArea($areasn, $type);
					break;

				case 2: //大棚光照
					$areaboxcontent->val = DeviceController::getIllumiFromArea($areasn, $type);
					break;

				case 3: //大棚C02浓度
					$areaboxcontent->val = DeviceController::getDioxideFromArea($areasn, $type);
					break;

				case 4: //大棚土壤温度
					$areaboxcontent->val = DeviceController::getWarmhouseSoilTempFromArea($areasn, $type);
					break;

				case 5: //大棚土壤水分
					$areaboxcontent->val = DeviceController::getWarmhouseSoilMoistureFromArea($areasn, $type);
					break;

				case 6: //大棚土壤PH值
					$areaboxcontent->val = DeviceController::getWarmhouseSoilPHFromArea($areasn, $type);
					break;

				case 7: //大棚气象风速
					$areaboxcontent->val = DeviceController::getWarmhouseAirSpeedFromArea($areasn, $type);
					break;

				case 8: //大棚气象风向
					$areaboxcontent->val = DeviceController::getWarmhouseAirDirectionFromArea($areasn, $type);
					break;

				case 9: //大棚气象降雨量
					$areaboxcontent->val = DeviceController::getWarmhouseRainfallFromArea($areasn, $type);
					break;

				case 10: //大棚控制设备数
					$areaboxcontent->val = DeviceController::getWarmhouseDeviceNumsFromArea($areasn);
					break;

				case 11: //养猪厂温度
					$areaboxcontent->val = DeviceController::getHogpenTempFromArea($areasn, $type);
					break;

				case 12: //养猪厂湿度
					$areaboxcontent->val = DeviceController::getHogpenHumiFromArea($areasn, $type);
					break;

				case 13: //养猪厂光照
					$areaboxcontent->val = DeviceController::getIllumiFromArea($areasn, $type);
					break;

				case 14: //养猪厂C02浓度
					$areaboxcontent->val = DeviceController::getDioxideFromArea($areasn, $type);
					break;

				case 15: //养猪厂氨气
					$areaboxcontent->val = DeviceController::getAmmoniaFromArea($areasn, $type);
					break;

				case 16: //养猪厂硫化氢
					$areaboxcontent->val = DeviceController::getHydrothionFromArea($areasn, $type);
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

	public static function getDevValueBySN($devsn) {
		$device = Device::where('sn', $devsn)->first();
		if ($device != null) {
			switch ($device->type) {
				case 2: return DeviceController::getWarmhouseHumiTempBySN($device->sn);
				case 3: return DeviceController::getIllumiBySN($device->sn);
				case 13: return DeviceController::getDioxideBySN($device->sn);
				case 7: return DeviceController::getAmmoniaBySN($device->sn);
				case 9:return DeviceController::getHydrothionBySN($device->sn);
			}
		}

		return '---';
	}

	//大棚温湿度
	public static function getWarmhouseHumiTempFromArea($areasn, $type) {

		$tempvals = array();
		$humivals = array();
		$devs = Device::where('area', $areasn)->where('type', DeviceController::getDevtypeFromBoxtype($type))->get();
		
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

	//大棚温湿度
	public static function getWarmhouseHumiTempBySN($devsn) {

		$dev = Device::where('sn', $devsn)->first();

		$temp = null;
		$humi = null;
		if($dev) {
			$temp = hexdec(substr($dev->data, 0, 4))/100;
			$humi = hexdec(substr($dev->data, 4, 8))/100;
		}

		$temp = ($temp == null ? '未知' : $temp.' ℃');
		$humi = ($humi == null ? '未知' : $humi.' %');

		return $temp.'/'.$humi;
	}

	//大棚土壤温度
	public static function getWarmhouseSoilTempFromArea($areasn, $type) {
		$soiltemp = DeviceController::getDevAverageFromArea($areasn, DeviceController::getDevtypeFromBoxtype($type));
		return $soiltemp == null ? '未知' : $soiltemp.'℃';
	}

	//大棚土壤水分
	public static function getWarmhouseSoilMoistureFromArea($areasn, $type) {
		$soilmoisture = DeviceController::getDevAverageFromArea($areasn, DeviceController::getDevtypeFromBoxtype($type), 'float');
		return $soilmoisture == null ? '未知' : $soilmoisture;
	}

	//大棚土壤PH值
	public static function getWarmhouseSoilPHFromArea($areasn, $type) {
		$soilph = DeviceController::getDevAverageFromArea($areasn, DeviceController::getDevtypeFromBoxtype($type), 'float');
		return $soilph == null ? '未知' : $soilph;
	}

	//大棚气象风速
	public static function getWarmhouseAirSpeedFromArea($areasn, $type) {
		$speed = DeviceController::getDevAverageFromArea($areasn, DeviceController::getDevtypeFromBoxtype($type), 'float');
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
	public static function getWarmhouseAirDirectionFromArea($areasn, $type) {
		$dev = Device::where('area', $areasn)->where('type', DeviceController::getDevtypeFromBoxtype($type))->first();
		if($dev == null || $dev->data == null) {
			return '未知';
		}
		else {
			return $dev->data;
		}
	}

	//大棚气象降雨量
	public static function getWarmhouseRainfallFromArea($areasn, $type) {
		$rainfall = DeviceController::getDevAverageFromArea($areasn, DeviceController::getDevtypeFromBoxtype($type));
		return $rainfall == null ? '未知' : $rainfall.'mm';
	}

	//大棚控制设备数
	public static function getWarmhouseDeviceNumsFromArea($areasn) {
		return Device::where('area', $areasn)->where('attr', 2)->count();
	}

	//养猪厂温度
	public static function getHogpenTempFromArea($areasn, $type) {
		$tempvals = array();
		$devs = Device::where('area', $areasn)->where('type', DeviceController::getDevtypeFromBoxtype($type))->get();

		foreach ($devs as $dev) {
			if($dev->data == null) {
				continue;
			}

			array_push($tempvals, hexdec(substr($dev->data, 0, 4))/100);
		}

		$temp = DeviceController::getAverageVal($tempvals);
		return $temp == null ? '未知' : $temp.' ℃';
	}

	//养猪厂湿度
	public static function getHogpenHumiFromArea($areasn, $type) {
		$humivals = array();
		$devs = Device::where('area', $areasn)->where('type', DeviceController::getDevtypeFromBoxtype($type))->get();
	
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
	public static function getIllumiFromArea($areasn, $type) {
		$devals = array();

		$devs = Device::where('area', $areasn)->where('type', DeviceController::getDevtypeFromBoxtype($type))->get();
		foreach ($devs as $dev) {
			if($dev->data == null) {
				continue;
			}

			array_push($devals, hexdec(substr($dev->data, 0, 4)));
		}

		$illumi = DeviceController::getAverageVal($devals);
		return $illumi === null ? '未知' : round($illumi).' Lux';
	}

	//光照
	public static function getIllumiBySN($devsn) {
		$illumi = null;

		$dev = Device::where('sn', $devsn)->first();
		if ($dev) {
			$illumi = hexdec(substr($dev->data, 0, 4));;
		}

		return $illumi === null ? '未知' : round($illumi).' Lux';
	}

	//C02浓度
	public static function getDioxideFromArea($areasn, $type) {
		$devals = array();

		$devs = Device::where('area', $areasn)->where('type', DeviceController::getDevtypeFromBoxtype($type))->get();
		foreach ($devs as $dev) {
			if($dev->data == null) {
				continue;
			}

			array_push($devals, hexdec(substr($dev->data, 0, 4)));
		}

		$dioxide = DeviceController::getAverageVal($devals);		
		return $dioxide === null ? '未知' : $dioxide.' ppm';
	}

	//C02浓度
	public static function getDioxideBySN($devsn) {
		$dioxide = null;
		$dev = Device::where('sn', $devsn)->first();
		if ($dev) {
			$dioxide = hexdec(substr($dev->data, 0, 4));
		}

		return $dioxide === null ? '未知' : $dioxide.' ppm';
	}

	//氨气
	public static function getAmmoniaFromArea($areasn, $type) {
		$devals = array();

		$devs = Device::where('area', $areasn)->where('type', DeviceController::getDevtypeFromBoxtype($type))->get();
		foreach ($devs as $dev) {
			if($dev->data == null) {
				continue;
			}

			array_push($devals, hexdec(substr($dev->data, 0, 4)));
		}

		$ammonia = DeviceController::getAverageVal($devals);		
		return $ammonia === null ? '未知' : $ammonia.' ppm';
	}

	//氨气
	public static function getAmmoniaBySN($devsn) {
		$ammonia = null;
		$dev = Device::where('sn', $devsn)->first();
		if ($dev) {
			$ammonia = hexdec(substr($dev->data, 0, 4));
		}

		return $ammonia === null ? '未知' : $ammonia.' ppm';
	}

	//硫化氢
	public static function getHydrothionFromArea($areasn, $type) {
		$devals = array();

		$devs = Device::where('area', $areasn)->where('type', DeviceController::getDevtypeFromBoxtype($type))->get();
		foreach ($devs as $dev) {
			if($dev->data == null) {
				continue;
			}

			array_push($devals, hexdec(substr($dev->data, 0, 4)));
		}

		$dydrothion = DeviceController::getAverageVal($devals);		
		return $dydrothion === null ? '未知' : $dydrothion.' ppm';
	}

	//硫化氢
	public static function getHydrothionBySN($devsn) {
		$dydrothion = null;
		$dev = Device::where('sn', $devsn)->first();
		if ($dev) {
			$dydrothion = hexdec(substr($dev->data, 0, 4));
		}

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

	/*
	 * Video Stream Operations
	 */
	public static function addDevCtrlRecord($device) {

		$user = User::where('name', 'root')->first();
    	if (!$user) {
    		$user = User::query()->first();
    	}

		$action = Action::where('content', '控制')->first();

		Ctrlrecord::create([
				'sn' => Controller::getRandNum(),
				'content' => '控制 "'.$device->name.'" '.$device->data,
				'usersn' => $user->sn,
				'action' => $action->id,
				'optnum' => Controller::getRandHex($user->email.$action->id.$device->sn.$device->data),
				'data' => null,
		]);
	}

	public static function getEasydarwinHLSList() {
	   $hlslist = null;
	   try {
	   $hlslist = file_get_contents(Globalval::getVal('easydarwin_service').Globalval::getVal('easydarwin_hlslist'),
						false,
						stream_context_create([
								'http' => [
									'method'  => 'POST',
									'header'  => 'Content-type: application/x-www-form-urlencoded',
									'content' => http_build_query([])
								]
						])
				);
	   } catch (\Exception $e) {
	       //return 'Caught exception: '.$e->getMessage().'\n';
	   }
	   
	   return $hlslist;
	}

	public static function getEasydarwinRTSPList() {
		return file_get_contents(Globalval::getVal('easydarwin_service').Globalval::getVal('easydarwin_rtsplist'),
				false,
				stream_context_create([
						'http' => [
								'method'  => 'POST',
								'header'  => 'Content-type: application/x-www-form-urlencoded',
								'content' => http_build_query([])
						]
				])
		);
	}

	public static function getFFmpegRTMPList() {
	    $rtlist = null;

	    try {
		$rtlist = file_get_contents(Globalval::getVal('node_service').Globalval::getVal('node_ffrtmp'),
						false,
						stream_context_create([
								'http' => [
									'method'  => 'POST',
									'header'  => 'Content-type: application/x-www-form-urlencoded',
									'content' => http_build_query(['opt' => 'list'])
								]
						])
				);
	    } catch (\Exception $e) {
	        //return 'Caught exception: '.$e->getMessage().'\n';
	    }

		return $rtlist;
	}

	public static function getFFmpegStorageList() {
	    $stlist = null;

	    try {
		$stlist = file_get_contents(Globalval::getVal('node_service').Globalval::getVal('node_ffstorage'),
				false,
				stream_context_create([
						'http' => [
								'method'  => 'POST',
								'header'  => 'Content-type: application/x-www-form-urlencoded',
								'content' => http_build_query(['opt' => 'list'])
						]
				])
		);
		} catch (\Exception $e) {
		    //return 'Caught exception: '.$e->getMessage().'\n';
		}

		return $stlist;
	}

	public static function addFFmpegRTMP($name, $rtsp_url) {
		return file_get_contents(Globalval::getVal('node_service').Globalval::getVal('node_ffrtmp'),
				false,
				stream_context_create([
						'http' => [
								'method'  => 'POST',
								'header'  => 'Content-type: application/x-www-form-urlencoded',
								'content' => http_build_query([
										'name' => $name,
										'opt' => 'add',
										'url' => $rtsp_url,
										'server' => Globalval::getVal('hostaddr'),
								        'pushtoserver' => Globalval::getVal('node_rtmptoserver_enable')
								])
						]
				])
		);

		/*Redis::publish('ffmpeg-rtmp', json_encode([
											'name' => $name,
											'opt' => 'add',
											'url' => $rtsp_url,
										]));*/
	}

	public static function addFFmpegStorage($name, $rtsp_url) {
		return file_get_contents(Globalval::getVal('node_service').Globalval::getVal('node_ffstorage'),
				false,
				stream_context_create([
						'http' => [
								'method'  => 'POST',
								'header'  => 'Content-type: application/x-www-form-urlencoded',
								'content' => http_build_query([
										'name' => $name,
										'opt' => 'add',
										'url' => $rtsp_url,
										'timelong' => Globalval::getVal('video_storage_timelong'),  //mins
										'path_dir' => Globalval::getVal('video_storage_path'),
								])
						]
				])
		);

		/*Redis::publish('ffmpeg-storage', json_encode([
												'name' => $name,
												'opt' => 'add',
												'url' => $rtsp_url,
												'timelong' => Globalval::getVal('video_storage_timelong'),  //mins
												'path_dir' => Globalval::getVal('video_storage_path'),
											]));*/
	}

	public static function delFFmpegRTMP($name) {
		return file_get_contents(Globalval::getVal('node_service').Globalval::getVal('node_ffrtmp'),
				false,
				stream_context_create([
						'http' => [
								'method'  => 'POST',
								'header'  => 'Content-type: application/x-www-form-urlencoded',
								'content' => http_build_query([
										'name' => $name,
										'opt' => 'del',
								])
						]
				])
		);

		/*Redis::publish('ffmpeg-rtmp', json_encode([
											'name' => $name,
											'opt' => 'del',
										]));*/
	}

	public static function delFFmpegStorage($name) {
		return file_get_contents(Globalval::getVal('node_service').Globalval::getVal('node_ffstorage'),
				false,
				stream_context_create([
						'http' => [
								'method'  => 'POST',
								'header'  => 'Content-type: application/x-www-form-urlencoded',
								'content' => http_build_query([
										'name' => $name,
										'opt' => 'del',
								])
						]
				])
		);

		/*Redis::publish('ffmpeg-storage', json_encode([
												'name' => $name,
												'opt' => 'del',
											]));*/
	}

	public static function pushRTMPStreamListToServer($list) {
		return file_get_contents('http://'
									.Globalval::getVal('hostaddr')
									.':8380/devdata?action=rtmplist&list='
									.$list);
	}

	public static function addEasydarwinHLS($name, $rtsp_url, $timeout) {
		return file_get_contents(Globalval::getVal('easydarwin_service').Globalval::getVal('easydarwin_addhls'),
						false,
						stream_context_create([
								'http' => [
									'method'  => 'POST',
									'header'  => 'Content-type: application/x-www-form-urlencoded',
									'content' => http_build_query([
											'n1' => $name,
											'n2' => $rtsp_url,
											'n3' => $timeout,
									])
								]
						])
				);
	}

	public static function addEasydarwinRTSP($name, $rtsp_url) {

		$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		$conn = socket_connect($sock, "127.0.0.1", 554);
		if($conn) {
			$optmsg = 'OPTIONS rtsp://127.0.0.1:554/EasyRelayModule?'.
					'name='.$name.'&url="'.$rtsp_url.'" '."RTSP/1.0\r\n"
					."CSeq: 2\r\n"
					."User-Agent: LibVLC/2.2.4 (LIVE555 Streaming Media v2016.02.22)\r\n\r\n";
			
			$desmsg = 'DESCRIBE rtsp://127.0.0.1:554/EasyRelayModule?'.
					'name='.$name.'&url="'.$rtsp_url.'" '."RTSP/1.0\r\n"
					."CSeq: 3\r\n"
					."User-Agent: LibVLC/2.2.4 (LIVE555 Streaming Media v2016.02.22)\r\n"
					."Accept: application/sdp\r\n\r\n";

			socket_write($sock, $optmsg);
			$ret = socket_read($sock, 1024);
			
			socket_write($sock, $desmsg);
			$ret = socket_read($sock, 1024);
		}
		socket_close($sock);
	}

	public static function delEasydarwinRTSP($name) {
	
		$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		$conn = socket_connect($sock, "127.0.0.1", 554);
		if($conn) {
			$optmsg = 'OPTIONS rtsp://127.0.0.1:554/EasyRelayModule?'.
					'name='.$name."&cmd=stop RTSP/1.0\r\n"
					."CSeq: 2\r\n"
					."User-Agent: LibVLC/2.2.4 (LIVE555 Streaming Media v2016.02.22)\r\n\r\n";
			
			$desmsg = 'DESCRIBE rtsp://127.0.0.1:554/EasyRelayModule?'.
					'name='.$name."&cmd=stop RTSP/1.0\r\n"
					."CSeq: 3\r\n"
					."User-Agent: LibVLC/2.2.4 (LIVE555 Streaming Media v2016.02.22)\r\n"
					."Accept: application/sdp\r\n\r\n";

			socket_write($sock, $optmsg);
			$ret = socket_read($sock, 1024);
			
			socket_write($sock, $desmsg);
			$ret = socket_read($sock, 1024);
		}
		socket_close($sock);
	}

	public static function delEasydarwinHLS($name) {
		return file_get_contents(Globalval::getVal('easydarwin_service').Globalval::getVal('easydarwin_delhls'),
						false,
						stream_context_create([
								'http' => [
									'method'  => 'POST',
									'header'  => 'Content-type: application/x-www-form-urlencoded',
									'content' => http_build_query(['n1' => $name])
								]
						])
				);
	}
}
