<?php

namespace App\Http\Controllers\CulliveBefore;

use Carbon\Carbon;
use App\Model\Device;
use App\Model\Alarminfo;
use App\Http\Controllers\Controller;

class ComputeController extends Controller
{
	public static function getDeviceUpdateRate() {

		$devices = Device::query();
		$all_count = $devices->count();

		if($all_count == 0) {
			return 0;
		}

		$max_time = $devices->max('updated_at');
		$day = date('Y-m-d', strtotime($max_time));

		$day_devices = Device::where('updated_at', 'like', $day.'%');
		$day_count = $day_devices->count();

		return round($day_count*100/$all_count, 2);
	}

	public static function getAlarminfoUpdateRate() {
		$alarminfos = Alarminfo::query();
		$all_count = $alarminfos->count();

		$max_time = $alarminfos->max('updated_at');
		$day = date('Y-m-d', strtotime($max_time));

		$day_alarminfos = Alarminfo::where('updated_at', 'like', $day.'%');
		$day_count = $day_alarminfos->count();
		if($day_count == 0) {
			return 0;
		}

		return round($day_count*100/$all_count, 2);
	}

	public static function getTimeFlag(Carbon $time) {
		if(strcmp(date('Y', time()), date('Y', strtotime($time))) != 0) {
			 return date('Y年', strtotime($time));
		}
		elseif(strcmp(date('m-d', time()-(1*24*60*60)), date('m-d', strtotime($time))) == 0) {
			return '昨天';
		}
		elseif(strcmp(date('m-d', time()), date('m-d', strtotime($time))) != 0) {
			return date('n月j日', strtotime($time));
		}
		else {
			return date('H:i:s', strtotime($time));
		}
	}
}