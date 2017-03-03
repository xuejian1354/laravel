<?php

namespace App\Http\Controllers\CulliveBefore;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Alarminfo;
use App\Model\Device;
use App\Http\Controllers\Controller;

class AlarminfoController extends Controller
{
    public static function addAlarminfo($action, $devsn, $thresval, $curdata = null) {

    	$device = Device::where('sn', $devsn)->first();
    	if($device == null) {
    		return;
    	}

    	if($curdata == null) {
    		$curdata = $device->data;
    	}

    	$content = null;
    	switch($action) {
    	case 'up':
    		$content = '"'.$device->name.'" 获得值 '.$curdata.'，超出阈值 '.$thresval.'.';
    		break;

    	case 'down':
    		$content = '"'.$device->name.'" 获得值 '.$curdata.'，低于阈值 '.$thresval.'.';
    		break;

    	case 'cmp':
    		$content = '"'.$device->name.'" 获得值 '.$curdata.'.';
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
    			'enable' => true,
    	]);
    }
}
