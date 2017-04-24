<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use App\Device;
use App\User;
use App\Record;
use App\Globalval;

class DevDataController extends Controller
{
    public function index() {

    	switch(Input::get('action', 'update')) {
    	case 'update': 
    	    
    	    $resn = Input::get('sn');
    	    $redata = Input::get('data');

    	    $qdev = Device::where('sn', Input::get('sn'))->first();
    		if($qdev != null) {
    		    if(substr($resn, -2) == '07') {
    		        $darr = [];
    		        for($i=0; $i<6; $i++) {
    		            $y = intval(substr($redata, 0, 2)) - 1;
    		            if( $y == $i) {
    		                if(substr($redata, 2, 2) == '01') {
    		                    $darr[$i] = '1';
    		                }
    		                else {
    		                    $darr[$i] = '0';
    		                }
    		            }
    		            else {
    		                $darr[$i] = substr($qdev->data, $i, 1);
    		            }
    		        }
    		        
    		        $redata = '';
    		        for($i=0; $i<6; $i++) {
    		            $redata .= $darr[$i];
    		        }
    		    }

	    		(new DevDataEvent(Input::get('sn'), $redata))->updateToPusher();
	    		return '<h2>Success</h2>'
	    				.'<span>Update device data!</span><br><br>'
	    				.'<span>sn: '.$resn.', data: '.$redata.'</span>';
    		}
    		else {
    		    if(substr($resn, -2) == '07') {
    		        $redata = '000000';
    		    }

    			$user = User::where('name', 'root')->first();
    			if (!$user) {
    				$user = User::query()->first();
    			}

    			Device::create([
    					'sn' => Input::get('sn'),
    					'type' => 0,
    					'attr' => 0,
    					'data' => $redata,
    					'psn' => Input::get('psn'),
    					'owner' => $user->sn,
    			]);

    			if(Globalval::getVal('record_support') == true) {
    				Record::create(['sn' => $resn, 'type' => 'dev', 'data' => 'add']);
    			}

    			return '<h2>Success</h2>'
    					.'<span>Create new device!</span><br><br>'
    					.'<span>sn: '.$resn.', data: '.$redata.'</span>';
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

    	case 'rtmplist':
    		if (Globalval::getVal('matrix') == 'server') {
    			$rtmplist = json_decode(Input::get('list'));
    			foreach ($rtmplist as $rtsteam) {
    				if(strpos($rtsteam->name, '_') === 0) {
	    				$vdev = Device::where('sn', $rtsteam->name)->first();
	    				if (!$vdev) {
	    					Device::create([
	    							'sn' => $rtsteam->name,
	    							'name' => $rtsteam->name,
	    							'type' => 1,
	    							'attr' => 3,
	    							'data' => json_encode([
	    									'protocol' => 'rtmp',
	    									'url' => $rtsteam->url,
	    							]),
	    					]);
	    				}
	    				else {
	    					$vdev->data = json_encode(['protocol' => 'rtmp', 'url' => $rtsteam->url]);
	    					$vdev->save();
	    				}
    				}
    			}
    		}

    		return 'NULL';
    	}
    }
}
