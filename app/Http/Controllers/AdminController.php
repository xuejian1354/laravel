<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ConsoleMenu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use App\Area;
use App\Record;
use App\Device;
use Illuminate\Support\Facades\Storage;
use App\Areabox;
use App\Areaboxcontent;
use App\Alarminfo;
use App\Msgboard;
use App\User;
use App\Devtype;
use App\Globalval;

class AdminController extends Controller
{
	public function index(Request $request) {

		if($request->isMethod('get')) {
			return redirect('curinfo');
		}
	}

	public function curInfo(Request $request, $curopt = null) {

		if($curopt == null) {
			$record = new \stdClass();
			$record->data = Record::query()->orderBy('updated_at', 'desc')->get();
			$record->hasmore = false;

			if(count($record->data) > 5) {
				$record->hasmore = true;
				$record->data = array_slice(iterator_to_array($record->data), 0, 5);
			}

			return $this->getViewWithMenus('curinfo', $request)
							->with('page_description', '智能农业控制平台')
							->with('record', $record);
		}
		elseif($curopt == 'user') {

			if($request->isMethod('post') && $request->input('way') == 'userdel') {
				$usersns = json_decode($request->input('usersns'));
				foreach ($usersns as $usersn) {
					$user = User::where('sn', $usersn)->first();
					$user->delete();
				}
			}

			/* User lists from page */
			$gp = Input::get('page');	//From URL
			$users = User::query();

			$pagetag = new PageTag(6, 3, $users->count(), $gp?$gp:1);
			$users = $users->orderBy('updated_at', 'desc')
							->paginate($pagetag->getRow());

			$recordcount = Record::query()->count();
			foreach ($users as $user) {
				$user->actcount = round(Record::where('usersn', $user->sn)->count() / $recordcount * 100, 2);
			}

			if($request->isMethod('post')) {
				if($request->input('way') == 'userlist' || $request->input('way') == 'userdel') {
					return view('curinfo.userlist')
							->with('request', $request)
							->with('pagetag', $pagetag)
							->with('users', $users);
				}
				else if($request->input('way') == 'useractive') {
					$user = User::where('sn', $request->input('usersn'))->first();
					if($user != null) {
						$user->active = true;
						$user->save();
						return 1;
					}
					else {
						return 0;
					}
				}
			}

			return $this->getViewWithMenus('curinfo.user', $request)
							->with('page_title', '用户')
							->with('pagetag', $pagetag)
							->with('users', $users);
		}
	}

	public function areaCtrl(Request $request, $areasn = null, $areaopt = null) {

		if($areaopt == 'camadd' && Globalval::getVal('video_support')) {
			$area = Area::where('sn', $areasn)->first();

			if($request->isMethod('post')) {
				$carmera = Device::where('sn', $request->input('camerasn'))->first();
				if($carmera != null && $area != null) {
					$carmera->area = $area->sn;
					$carmera->save();
					return 'OK';
				}
				return 'FAIL';
			}

			if($area == null) {
				$area = Area::query()->first();
			}

			$cameras = Device::where('type', 1)->get();

			return $this->getViewWithMenus('areactrl.camadd', $request)
							->with('page_title', '添加摄像头')
							->with('area', $area)
							->with('cameras', $cameras);
		}

		DeviceController::updateAreaboxDB($areasn);

		/* Area */
		$area = Area::where('sn', $areasn)->first();
		if($area == null) {
			$area = Area::query()->first();
		}

		/* Box & Content */
		$areaboxes = Areabox::where('area_type', $area->type)->get();
		foreach ($areaboxes as $areabox) {
			$areabox->contents = Areaboxcontent::where('area_sn', $area->sn)->where('box_id', $areabox->id)->get();
		}

		if($request->isMethod('post')) {
			if($request->input('way') == 'devlist') {
				return view('areactrl.devlist')
						->with('request', $request)
						->with($this->getDevicesWithPage($area->sn, 2));
			}
		}

		/* Video file */
		$vcamnames = null;
		$vcams = Device::where('type', 1)->where('area', $area->sn)->get();
		if (count($vcams) > 0) {
			$vcamnames = array();
			foreach ($vcams as $vcam) {
				array_push($vcamnames, $vcam->sn);
			}
		}

		$video_file = $this->getRandVideoName($vcamnames);

		/* View */
		return $this->getViewWithMenus('areactrl', $request)
						->with('area', $area)
						->with('areaboxes', $areaboxes)
						->with($this->getDevicesWithPage($area->sn, 2))
						->with('video_file', $video_file);
	}

	public function devStats(Request $request, $devopt = null) {

		if($devopt == null) {
			if($request->isMethod('post')) {
				if($request->input('way') == 'devlist') {
					return view('devstats.devlist')
							->with('request', $request)
							->with('devtypes', Devtype::all())
							->with('areas', Area::all())
							->with($this->getDevicesWithPage());
				}
			}

			return $this->getViewWithMenus('devstats', $request)
							->with('devtypes', Devtype::all())
							->with('areas', Area::all())
							->with($this->getDevicesWithPage());
		}
		else if ($devopt == 'device') {
			$device = Device::where('sn', $request->get('sn'))->first();
			
			if($request->isMethod('post')) {
				if ($request->input('way') == 'del') {
					if($device != null) {
						$device->delete();
						return 'OK';
					}
					return 'FAIL';
				}
				else if ($request->input('way') == 'nameedt') {
					if($device != null) {
						$device->name = $request->input('value');
						$device->save();

						return $device->updated_at;
					}
					return 'FAIL';
				}
				else if ($request->input('way') == 'typeedt') {
					if($device != null) {
						$device->type = $request->input('value');
						$device->name = $device->rel_type->name.substr($device->sn, 2);
						$device->attr = $device->rel_type->attr;
						$device->save();
						return $device->updated_at;
					}
					return 'FAIL';
				}
				else if ($request->input('way') == 'areaedt') {
					if($device != null) {
						$device->area = $request->input('value');
						$device->save();
						return $device->updated_at;
					}
					return 'FAIL';
				}
				else if ($request->input('way') == 'dataedt') {
					if($device != null) {
						$device->data = $request->input('value');
						$device->save();
						return $device->updated_at;
					}
					return 'FAIL';
				}
				else if ($request->input('way') == 'alarmedt') {
					if($device != null) {
						$device->alarmthres = $request->input('value');
						$device->save();
						return $device->updated_at;
					}
					return 'FAIL';
				}
				else if ($request->input('way') == 'owneredt') {
					if($device != null) {
						$device->owner = $request->input('value');
						$device->save();
						return $device->updated_at;
					}
					return 'FAIL';
				}
			}

			if($device == null) {
				return redirect('devstats');
			}

			return $this->getViewWithMenus('devstats.device', $request)
							->with('page_description', $device->name)
							->with('page_title', '设备')
							->with('device', $device)
							->with('devtypes', Devtype::all())
							->with('areas', Area::all())
							->with('users', User::all());
		}
	}

	public function videoReal(Request $request, $camopt = null) {

		if(Globalval::getVal('video_support') == false) {
			return '<h3>Video not Support !</h3><p>Please setting "video_support" on Database.</p>';
		}

		if($request->isMethod('post')) {
			if($camopt == 'camedt') {
				$device = Device::where('sn', $request->input('sn'))->first();
				if($device != null) {
					$device->name = $request->input('name');
					$device->save();
					return 'OK';
				}

				return 'FAIL';
			}
			else if($camopt == 'camdel') {
				$device = Device::where('sn', $request->input('sn'))->first();
				if($device != null) {
					$device->delete();
					DeviceController::delEasydarwinHLS($request->input('sn'));
					DeviceController::delEasydarwinRTSP($request->input('sn'));
					return 'OK';
				}

				return 'FAIL';
			}
			else if($camopt == 'camadd') {
				$sn = $request->input('sn');
				$stream_type = $request->input('type');
				$url = $request->input('url');
				if($stream_type == 'rtsp') {
					DeviceController::addEasydarwinHLS($sn, $url, 0);
					DeviceController::addEasydarwinRTSP($sn, $url);
					return 'OK';
				}
				else if ($stream_type == 'hls' || $stream_type == 'rtmp') {
					$data = ['protocol' => $stream_type, 'url' => $url];

					Device::create([
							'sn' => $sn,
							'name' => $sn,
							'type' => 1,
							'attr' => 3,
							'data' => json_encode($data),
					]);

					return 'OK';
				}

				return 'FAIL';
			}
		}
		else if($camopt == 'camadd') {
			return $this->getViewWithMenus('videoreal.camadd', $request)
						->with('page_title', '摄像头');
		}

		$gp = Input::get('page');	//From URL

		$video_files = $this->getAllVideoNames();
		$pagetag = new PageTag(6, 3, count($video_files), $gp?$gp:1);

		$video_files = array_slice($video_files, ($pagetag->getPage()-1)*6, 6);

		if($request->isMethod('post')) {
			if($request->input('way') == 'videolist') {
				return view('videoreal.videolist')
						->with('request', $request)
						->with('pagetag', $pagetag)
						->with('video_files', $video_files);
			}
		}

		return $this->getViewWithMenus('videoreal', $request)
						->with('pagetag', $pagetag)
						->with('video_files', $video_files)
						->with('video_rand', $this->getRandVideoName());
	}

	public function alarmInfo(Request $request) {

		if($request->isMethod('post')) {
			if($request->input('way') == 'alarmlist') {
				return view('alarminfo.alarmlist')
						->with('request', $request)
						->with($this->getAlarminfosWithPage());
			}
			else if($request->input('way') == 'msgdel') {
				$delinfos = json_decode($request->input('infos'));
				foreach ($delinfos as $delinfo) {
					$alarminfo = Alarminfo::where('sn', $delinfo)->first();
					$alarminfo->delete();
				}

				return view('alarminfo.alarmlist')
						->with('request', $request)
						->with($this->getAlarminfosWithPage());
			}
			else if($request->input('way') == 'msgadd') {
				$color = $request->input('color');
				$content = $request->input('content');
				if(trim($content) == '') {
					$content = '<br>';
				}

				$msgboards = Msgboard::orderBy('updated_at', 'asc');
				if(count($msgboards->get()) < 6) {
					Msgboard::create([
							'bgcolor' => $color,
							'content' => $content,
					]);
				}
				else {
					$addmsg = $msgboards->first();
					$addmsg->bgcolor = $color;
					$addmsg->content = $content;
					$addmsg->save();
				}

				$msgboards = Msgboard::orderBy('updated_at', 'desc')->limit(6)->get();
				return view('alarminfo.msglist')
						->with('msgboards', $msgboards);
			}
		}

		$msgboards = Msgboard::orderBy('updated_at', 'desc')->limit(6)->get();

		return $this->getViewWithMenus('alarminfo', $request)
						->with('msgboards', $msgboards)
						->with('alarminforate', ComputeController::getAlarminfoUpdateRate())
						->with($this->getAlarminfosWithPage());
	}

	public function getViewWithMenus($view = null, Request $request, $data = [], $mergeData = [])
	{
		$select_menus = array();
		$console_menus = (new ConsoleMenu())->getConsleMenuLists($request->path());

		foreach ($console_menus as $menus) {
			foreach ($menus as $menu) {
				if(isset($menu->isactive) && $menu->isactive == true) {
					array_push($select_menus, $menu);
				}
			}
		}

		return view($view, $data, $mergeData)
				->with('request', $request)
				->with('reurl', $this->getReurlArray())
				->with('select_menus', $select_menus)
				->with('console_menus', $console_menus);
	}

	protected function getDevicesWithPage($area = null, $attr = null) {
		/* Device lists from page */
		$gp = Input::get('page');	//From URL

		$devices = Device::where('attr', '!=', 3);	//All devices, except camera
		if($area != null) {
			$devices = $devices->where('area', $area);
		}

		if($attr != null) {
			$devices = $devices->where('attr', $attr);
		}

		$pagetag = new PageTag(8, 3, $devices->count(), $gp?$gp:1);
		$devices = $devices->orderBy('updated_at', 'desc')
							->paginate($pagetag->getRow());

		return ['pagetag' => $pagetag, 'devices' => $devices];
	}

	protected function getAlarminfosWithPage() {
		/* Device lists from page */
		$gp = Input::get('page');	//From URL

		$alarminfos = Alarminfo::query(); //All alarminfos

		$pagetag = new PageTag(8, 3, $alarminfos->count(), $gp?$gp:1);
		$alarminfos = $alarminfos->orderBy('updated_at', 'desc')
								->paginate($pagetag->getRow());

		$pagetag->col_start = ($pagetag->getPage()-1)*$pagetag->getRow()+1;
		$pagetag->col_end = $pagetag->col_start + $alarminfos->count()-1;

		return ['pagetag' => $pagetag, 'alarminfos' => $alarminfos];
	}

	public function getAllVideoNames($selnames = null, $edtypes = 'm3u8|rtmp') {

		if(Globalval::getVal('video_support') == false) {
			return null;
		}

		$typesarr = explode('|', $edtypes);

		$video_file_names = array();
		$dbcams = Device::where('attr', 3);

		$edjson = json_decode(DeviceController::getEasydarwinHLSList());
		if(isset($edjson->EasyDarwin->Body->Sessions)) {
			//dd($edjson);
			foreach ($edjson->EasyDarwin->Body->Sessions as $session) {
				$sn = $session->name;
				$name = $sn;
	
				//Camera info match with DB
				$camdev = Device::where('sn', $sn)->first();
				if($camdev == null) {
					$data = new \stdClass();
					$data->protocol = 'rtsp';
					$data->source = $session->source;

					$reqarr = parse_url($session->url);
					$data->host = $reqarr['host'];
					$data->hls_port = $reqarr['port'];
					$data->hls_path = $reqarr['path'];

					Device::create([
	        				'sn' => $sn,
	        				'name' => $name,
	        				'type' => 1,
	        				'attr' => 3,
	        				'data' => json_encode($data),
	        				'owner' => User::where('name', 'root')->first()->sn,
	        		]);
				}
				else {
					$dbcams = $dbcams->where('sn', '!=', $sn);
	
					$name = $camdev->name;

					$data = json_decode($camdev->data);
					$data->protocol = 'rtsp';
					$data->source = $session->source;

					$reqarr = parse_url($session->url);
					$data->host = $reqarr['host'];
					$data->hls_port = $reqarr['port'];
					$data->hls_path = $reqarr['path'];

					$camdev->data = json_encode($data);

					$camdev->save();
				}

				if(array_search('m3u8', $typesarr) !== false) {
					//Select by names
					if($selnames != null && count($selnames) > 0) {
						foreach ($selnames as $selname) {
							if ($selname == $sn) {
								array_push($video_file_names, [ 'id' => $sn,
										'type' => 'm3u8',
										'name' => $name,
										'url' => 'http://'.$data->host.':'.$data->hls_port.$data->hls_path ]);
								break;
							}
						}
	
						continue;
					}
	
					array_push($video_file_names, [ 'id' => $sn,
							'type' => 'm3u8',
						  	'name' => $name,
							'url' => 'http://'.$data->host.':'.$data->hls_port.$data->hls_path ]);
				}
			}
		}

		$rtjson = json_decode(DeviceController::getEasydarwinRTSPList());
		if(isset($rtjson->EasyDarwin->Body->Sessions)) {
			//dd($rtjson);
			foreach ($rtjson->EasyDarwin->Body->Sessions as $session) {
				$sn = $session->name;
				$name = $sn;

				//Camera info match with DB
				$camdev = Device::where('sn', $sn)->first();
				if($camdev == null) {
					$data = new \stdClass();
					$data->protocol = 'rtsp';

					$reqarr = parse_url($session->url);
					if($reqarr['host'] != '127.0.0.1') {
						$data->host = $reqarr['host'];
					}
					$data->rtsp_port = $reqarr['port'];
					$data->rtsp_path = $reqarr['path'];

					Device::create([
							'sn' => $sn,
							'name' => $name,
							'type' => 1,
							'attr' => 3,
							'data' => json_encode($data),
							'owner' => User::where('name', 'root')->first()->sn,
					]);
				}
				else {
					$dbcams = $dbcams->where('sn', '!=', $sn);

					$name = $camdev->name;

					$data = json_decode($camdev->data);
					$data->protocol = 'rtsp';

					$reqarr = parse_url($session->url);
					$data->rtsp_port = $reqarr['port'];
					$data->rtsp_path = $reqarr['path'];

					$camdev->data = json_encode($data);

					$camdev->save();
				}

				if(array_search('sdp', $typesarr) !== false) {
					//Select by names
					if($selnames != null && count($selnames) > 0) {
						foreach ($selnames as $selname) {
							if ($selname == $sn) {
								array_push($video_file_names, [ 'id' => $sn,
										'type' => 'sdp',
										'name' => $name,
										'url' => 'rtsp://'.$data->host.':'.$data->rtsp_port.$data->rtsp_path ]);
								break;
							}
						}

						continue;
					}

					array_push($video_file_names, [ 'id' => $sn,
							'type' => 'sdp',
							'name' => $name,
							'url' => 'rtsp://'.$data->host.':'.$data->rtsp_port.$data->rtsp_path ]);
				}
			}
		}

		if($selnames == null) {
			foreach ($dbcams->get() as $dbcam) {
				$data = json_decode($dbcam->data);
				if(isset($data->protocol) && $data->protocol == 'rtsp') {
					if(array_search('m3u8', $typesarr) !== false) {
						array_push($video_file_names, [ 'id' => $dbcam->sn,
								'type' => 'm3u8',
								'name' => $dbcam->name,
								'url' => 'http://'.$data->host.':'.$data->hls_port.$data->hls_path ]);
					}
					else if(array_search('sdp', $typesarr) !== false) {
						array_push($video_file_names, [ 'id' => $dbcam->sn,
								'type' => 'sdp',
								'name' => $dbcam->name,
								'url' => 'rtsp://'.$data->host.':'.$data->rtsp_port.$data->rtsp_path ]);
					}
	
					if($data->protocol == 'rtsp' && isset($data->source)) {
						if(parse_url($data->source)['host'] == '127.0.0.1') {
							$dbcam->delete();
						}
						else {
							DeviceController::addEasydarwinHLS($dbcam->sn, $data->source, 0);
							DeviceController::addEasydarwinRTSP($dbcam->sn, $data->source);
						}
					}
				}
				if(isset($data->protocol) && $data->protocol == 'hls') {
					array_push($video_file_names, [ 'id' => $dbcam->sn,
													'type' => 'm3u8',
													'name' => $dbcam->name,
													'url' => $data->url ]);
				}
				else if(isset($data->protocol) && $data->protocol == 'rtmp') {
					array_push($video_file_names, [ 'id' => $dbcam->sn,
													'type' => 'rtmp',
													'name' => $dbcam->name,
													'url' => $data->url ]);
				}
			}
		}
		elseif (array_search('rtmp', $typesarr) !== false) {
			foreach ($dbcams->get() as $dbcam) {
				$data = json_decode($dbcam->data);
				if(isset($data->protocol) && $data->protocol == 'rtmp') {
					array_push($video_file_names, [ 'id' => $dbcam->sn,
													'type' => 'rtmp',
													'name' => $dbcam->name,
													'url' => $data->url ]);
				}
			}
		}

		if($selnames == null || count($video_file_names) == 0) {
			$video_files = Storage::files('/public/video');
			foreach ($video_files as $video_file) {
				$video_file_path_array = explode('/', $video_file);
				$name = end($video_file_path_array);

				array_push($video_file_names, ['id' => str_replace('.', '', $name), 'type' => 'mp4', 'name' => $name, 'url' => '/video/'.$name]);
			}
		}

		return $video_file_names;
	}

	protected function getRandVideoName($names = null) {

		if(Globalval::getVal('video_support') == false) {
			return null;
		}

		$video_file_names = $this->getAllVideoNames($names);
		if(count($video_file_names) == 0) {
			return null;
		}

		return $video_file_names[array_rand($video_file_names)];
	}

	public static function getReurlArray() {
		$reurl = Array();
		foreach (['menu_stats'] as $ele) {
			$val = Input::get($ele);
			if($val != null) {
				$reurl[$ele] = $val;
			}
		}

		return $reurl;
	}

	public static function withurl($url) {

		$params = '';

		$reurl = AdminController::getReurlArray();
		foreach ($reurl as $k => $v) {
			$params .= '&'.$k.'='.$v;
		}
		$params = substr($params, 1);

		if(strstr($url, '?') == false && strlen($params) > 0) {
			$url .= '?';
		}
		$url .= $params;

		return url($url);
	}
}
    