<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Alarminfo;
use App\Device;

class AlarminfoController extends Controller
{
    public static function addAlarminfo($action, $devsn, $thresval) {

    	$device = Device::where('sn', $devsn)->first();
    	if($device == null) {
    		return;
    	}

    	$content = null;
    	switch($action) {
    	case 'up':
    		$content = '"'.$device->name.'" 获得值 '.$device->data.'，超出阈值 '.$thresval.'.';
    		break;

    	case 'down':
    		$content = '"'.$device->name.'" 获得值 '.$device->data.'，低于阈值 '.$thresval.'.';
    		break;

    	case 'cmp':
    		$content = '"'.$device->name.'" 获得值 '.$device->data.'.';
    		break;
    	}

    	Alarminfo::create([
    			'sn' => Controller::getRandHex(),
    			'content' => $content,
    			'devsn' => $devsn,
    			'action' => $action,
    			'thres' => $thresval,
    			'val' => $device->data,
    			'optnum' => Controller::getRandHex($devsn.$action.$thresval.$device->data),
    			'isread' => false,
    	]);
    }
}
