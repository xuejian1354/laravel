<?php

namespace App\Http\Controllers;

use App\Device;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\AlarminfoController;
use Illuminate\Support\Facades\Redis;
use App\Record;

class DevDataEvent
{
    public $sn, $data, $value, $attr, $areaboxcontents, $updated_at;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($sn, $data)
    {
        $this->sn = $sn;
        $this->data = $data;
        $this->areaboxcontents = array();

        $this->updateToDB();
    }

    public function dataToArray()
    {
    	$dataArray = array();

    	foreach(['sn' => $this->sn,
    			'data' => $this->data,
    			'value' => $this->value,
    			'attr' => $this->attr, 
    			'updated_at' => $this->updated_at,
    			'areaboxcontents' => $this->areaboxcontents] as $key => $value)
    	{
    		$value != null && $dataArray[$key] = $value;
    	}

    	return json_encode($dataArray);
    }

    public function updateToPusher() {

    	$record = $this->dataToArray();

    	Record::create(['sn' => $this->sn, 'type' => 'dev', 'data' => $record]);
    	Redis::publish('devdata-updating', $record);

    	return $this->updated_at;
    } 

    public function updateToDB() {
    	$device = Device::where('sn', $this->sn)->first();
    	if ($device != null) {
    		$before_data = $device->data; 
    		$device->data = $this->data;
    		$device->save();

    		// update areabox
    		if($device->attr == 1) {
    			$contenttype = [];
    			switch ($device->type) {
    			case 2:
    				$contenttype = [1, 11, 12];	//温湿度
    				$this->value = DeviceController::getWarmhouseHumiTempBySN($device->sn);
    				break;

    			case 3:
    				$contenttype = [2, 13];	//光照
    				$this->value = DeviceController::getIllumiBySN($device->sn);
   					break;

   				case 13:
    				$contenttype = [3, 14];	//C02浓度
    				$this->value = DeviceController::getDioxideBySN($device->sn);
    				break;

    			case 19:
    				$contenttype = [4];	//土壤温度
    				break;

    			case 20:
    				$contenttype = [5];	//土壤水分
    				break;

    			case 22:
    				$contenttype = [6];	//土壤PH值
    				break;

    			case 5:
    				$contenttype = [7];	//气象风速
    				break;

    			case 6:
    				$contenttype = [8];	//气象风向
    				break;

    			case 4:
    				$contenttype = [9];	//气象降雨量
    				break;

    			case 7:
    				$contenttype = [15];	//氨气
    				$this->value = DeviceController::getAmmoniaBySN($device->sn);
    				break;

    			case 9:
    				$contenttype = [16];	//硫化氢
    				$this->value = DeviceController::getHydrothionBySN($device->sn);
    				break;
    			}

    			foreach ($contenttype as $ct) {
    				$areaboxcontent = DeviceController::updateAreaboxDB($device->area, $ct);
    				if($areaboxcontent != null) {
    					array_push($this->areaboxcontents, $areaboxcontent);
    				}
    			}
    		}

    		$this->attr = $device->attr;

    		//trigger alarminfo
    		$alarmthres = json_decode($device->alarmthres);

    		if($alarmthres != null) {
	    		$thresvals = explode('/', $alarmthres->v);
	    		for ($index=0; $index<count($thresvals); $index++) {
	    			$curdata = hexdec(substr($device->data, $index*4, ($index+1)*4));
	    			$checkdata = hexdec(substr($before_data, $index*4, ($index+1)*4));

	    			//温湿度
	    			if($device->type == 2) {
	    				$curdata = $curdata/100;
	    				$checkdata = $checkdata/100;
	    			}

	    			switch($alarmthres->m) {
	    			case 'up':
	    				if($curdata > $thresvals[$index] && $thresvals[$index] >= $checkdata) {
	    					AlarminfoController::addAlarminfo($alarmthres->m, $device->sn, $alarmthres->v, $curdata);
	    				}
	    				break;
	
	    			case 'down':
	    				if($curdata < $thresvals[$index] && $thresvals[$index] <= $checkdata) {
	    					AlarminfoController::addAlarminfo($alarmthres->m, $device->sn, $alarmthres->v, $curdata);
	    				}
	    				break;
	
	    			case 'cmp':
						if($curdata == $thresvals[$index] && $thresvals[$index] != $checkdata) {
							AlarminfoController::addAlarminfo($alarmthres->m, $device->sn, $alarmthres->v, $curdata);
						}
						break;
	
	    			case 'none':
	    				break;
	    			}
	    		}
    		}

    		$this->updated_at = date('H:i:s', strtotime($device->updated_at));

    		// update devctrl record
    		if($device->attr == 2) {
    			DeviceController::addDevCtrlRecord($device);
    		}
    	}
    } 

    public function test() {
    	dd($this->dataToArray());
    }
}
