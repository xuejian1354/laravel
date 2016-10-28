<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Device;
use App\User;

class DevDataController extends Controller
{
    public function index() {

    	switch(Input::get('action', 'update')) {
    	case 'update': 
    		if(Device::where('sn', Input::get('sn'))->first() != null) {
	    		(new DevDataEvent(Input::get('sn'), Input::get('data')))->updateToPusher();
	    		return '<h2>Success</h2>'
	    				.'<span>Update device data!</span><br><br>'
	    				.'<span>sn: '.Input::get('sn').', data: '.Input::get('data').'</span>';
    		}
    		else {
    			Device::create([
    					'sn' => Input::get('sn'),
    					'type' => 0,
    					'attr' => 0,
    					'data' => Input::get('data'),
    					'psn' => Input::get('psn'),
    					'owner' => User::where('name', 'root')->firstOrFail()->sn,
    			]);

    			return '<h2>Success</h2>'
    					.'<span>Create new device!</span><br><br>'
    					.'<span>sn: '.Input::get('sn').', data: '.Input::get('data').'</span>';
    		}

    	case 'threshold':
    		$holds = explode(':', Input::get('threshold'));
    		if(count($holds) >= 2) {
    			$device = Device::where('sn', Input::get('sn'))->first();
    			if($device != null && in_array($holds[0], ['up', 'down', 'cmp', 'none'])) {
    				$device->alarmthres = json_encode(['m' => $holds[0], 'v' => $holds[1]]);
    				$device->save();

	    			return '<h2>Success</h2>'
	    				.'<span>Set device alarm threshold!</span><br><br>'
	    				.'<span>sn: '.Input::get('sn').', method: '.$holds[0].', threshold: '.$holds[1].'</span>';
    			}
    		}

    		return '<h2>Fail</h2><span>Set device alarm threshold!</span>';
    	}
    }
}
