<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Device;
use App\Http\Controllers\DeviceController;

class DevDataEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $sn, $data, $attr, $areaboxcontent, $updated_at;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($sn, $data)
    {
        $this->sn = $sn;
        $this->data = $data;
        $this->areaboxcontent = null;

        $this->updateToDB();
    }

    public function dataToArray()
    {
    	$dataArray = array();

    	foreach(['sn' => $this->sn, 'data' => $this->data, 'updated_at' => $this->updated_at] as $key => $value)
    	{
    		$value != null && $dataArray[$key] = $value;
    	}

    	return $dataArray;
    }

    public function updateToPusher() {
    	// Disable pusher because trigger by event()

    	//$pusher = \Illuminate\Support\Facades\App::make('pusher');
    	//$pusher->trigger($this->broadcastOn(), $this->broadcastAs(), $this->dataToArray());
    } 

    public function updateToDB() {
    	$device = Device::where('sn', $this->sn)->first();
    	if ($device != null) {
    		$device->data = $this->data;
    		$device->save();

    		if($device->attr == 1) {
    			$contenttype = null;
    			switch ($device->type) {
    			case 2:
    			case 3:
    				$contenttype = 1;	//温湿度
    				break;

    			case 4:
    				$contenttype = 2;	//光照
   					break;

   				case 14:

    				$contenttype = 3;	//C02浓度
    				break;

    			case 20:
    				$contenttype = 4;	//土壤温度
    				break;

    			case 21:
    				$contenttype = 5;	//土壤水分
    				break;

    			case 23:
    				$contenttype = 6;	//土壤PH值
    				break;

    			case 6:
    				$contenttype = 7;	//气象风速
    				break;

    			case 7:
    				$contenttype = 8;	//气象风向
    				break;

    			case 5:
    				$contenttype = 9;	//气象降雨量
    				break;
    			}

    			$this->areaboxcontent = DeviceController::updateAreaboxDB($device->area, $contenttype);
    		}

    		$this->attr = $device->attr;
    	}

    	$this->updated_at = date('H:i:s', strtotime($device->updated_at));

    	if($device->attr == 2) {
    		DeviceController::addDevCtrlRecord($device);
    	}
    } 

    public function test() {
    	dd($this->dataToArray());
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['devdata-updating'];
    }

    /**
     * Get the names the event should broadcast as.
     *
     * @return Name|string
     */
    public function broadcastAs()
    {
    	return 'update';
    }
}
