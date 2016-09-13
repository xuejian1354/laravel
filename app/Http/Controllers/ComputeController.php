<?php

namespace App\Http\Controllers;

use App\Device;

class ComputeController extends Controller
{
	public static function getDeviceUpdateRate() {

		$devices = Device::query();
		$all_count = $devices->count();

		$max_time = $devices->max('updated_at');
		$day = date('Y-m-d', strtotime($max_time));

		$day_devices = Device::where('updated_at', 'like', $day.'%');
		$day_count = $day_devices->count();

		return round($day_count*100/$all_count, 2);
	}
}