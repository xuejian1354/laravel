<?php

namespace App\Http\Controllers;

use Auth;
use App\Alarminfo;
use App\Area;
use App\Areabox;
use App\Areaboxcontent;
use App\ConsoleMenu;
use App\Ctrlrecord;
use App\Device;
use App\Devtype;
use App\Globalval;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Msgboard;
use App\Record;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
	public function index(Request $request) {

		if($request->isMethod('get')) {
			return view('index');
		}
	}

	public function curInfo(Request $request, $curopt = null) {

		if($curopt == null) {
			$record = new \stdClass();
			$record->data = Ctrlrecord::query()->orderBy('updated_at', 'desc')->get();
			$record->hasmore = false;

			if(count($record->data) > 5) {
				$record->hasmore = true;
				$record->data = array_slice(iterator_to_array($record->data), 0, 5);
			}

			return $this->getViewWithMenus('curinfo', $request)
							->with('page_description', '智能农业监控平台')
							->with('record', $record);
		}
		elseif($curopt == 'user') {

			if($request->isMethod('post') && $request->input('way') == 'userdel') {
				$usersns = json_decode($request->input('usersns'));
				foreach ($usersns as $usersn) {
					$user = User::where('sn', $usersn)->first();
					if(Globalval::getVal('record_support') == true) {
						Record::create(['sn' => $user->sn, 'type' => 'user', 'data' => 'delete']);
					}

					$user->delete();
				}
			}

			/* User lists from page */
			$gp = Input::get('page');	//From URL
			$users = User::query();

			$pagetag = new PageTag(6, 3, $users->count(), $gp?$gp:1);
			$users = $users->orderBy('updated_at', 'desc')
							->paginate($pagetag->getRow());

			$recordcount = Ctrlrecord::query()->count();
			foreach ($users as $user) {
				$user->actcount = round(Ctrlrecord::where('usersn', $user->sn)->count() / $recordcount * 100, 2);
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

						if(Globalval::getVal('record_support') == true) {
							Record::create(['sn' => $user->sn, 'type' => 'user', 'data' => 'active']);
						}
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
				$camera = Device::where('sn', $request->input('camerasn'))->first();
				if($camera != null && $area != null) {
					$camera->area = $area->sn;
					$camera->save();

					if(Globalval::getVal('record_support') == true) {
						Record::create([
								'sn' => $camera->sn,
								'type' => 'dev',
								'data' => '{"action":"camtoarea", "area":"'.$camera->area.'"}'
						]);
					}
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
		else if(Globalval::getVal('record_support') == true && $areaopt == 'record') {
			if($request->isMethod('post')) {
				return $this->getDeviceRecord($request);
			}
			else {
				$device = Device::where('sn', $request->get('sn'))->first();
				if($device == null) {
					return redirect('areactrl/'.$areasn);
				}

				return $this->getViewWithMenus('devstats.record', $request)
								->with('page_description', $device->name)
								->with('page_title', '设备')
								->with('device', $device);
			}
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
			$devtypes = array();
			$brel_contents = $areabox->rel_contents;
			foreach ($brel_contents as $brel_content) {
				$devtype = DeviceController::getDevtypeFromBoxtype($brel_content->type);
				array_push($devtypes, $devtype);
			}
			$devtypes = array_unique($devtypes);

			$areabox->contents = Areaboxcontent::where('area_sn', $area->sn)->where('box_id', $areabox->id)->get();

			$pagewithdevs = $this->getDevicesWithPage(null,
													  null,
					                                  0,
													  Device::where('area', $area->sn)
																->whereIn('type', $devtypes));

			$areabox->pagetag = $pagewithdevs['pagetag'];
			$areabox->devices = $pagewithdevs['devices'];
		}

		if($request->isMethod('post')) {
			$waystr = $request->input('way');
			if(strstr($waystr, 'devlist') !== false) {
				$listid = substr($waystr, 7);
				if($listid == 0) {	//ctrl devices
					$pagewithdevs = $this->getDevicesWithPage($area->sn, 2);
				}
				else {
					foreach ($areaboxes as $areabox) {
						if($listid ==$areabox->id) {
							$pagewithdevs = ['pagetag' => $areabox->pagetag, 'devices' => $areabox->devices];
						}
					}
				}

				return view('areactrl.devlist')
						->with('listid', $listid)
						->with('request', $request)
						->with($pagewithdevs);
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

		$video_file = $this->getRandVideoName($vcamnames, 'rtsp');

		/* View */
		return $this->getViewWithMenus('areactrl', $request)
						->with('listid', 0)
						->with('area', $area)
						->with('areaboxes', $areaboxes)
						->with($this->getDevicesWithPage($area->sn, 2))
						->with('video_file', $video_file);
	}

	public function devStats(Request $request, $devopt = null) {

		if ($devopt == 'device') {
			$device = Device::where('sn', $request->get('sn'))->first();

			if($request->isMethod('post')) {
				if ($request->input('way') == 'del') {
					if($device != null) {
						if(Globalval::getVal('record_support') == true) {
							Record::create(['sn' => $device->sn, 'type' => 'dev', 'data' => 'delete']);
						}
						$device->delete();
						return 'OK';
					}
					return 'FAIL';
				}
				else if ($request->input('way') == 'nameedt') {
					if($device != null) {
						$device->name = $request->input('value');
						if(Globalval::getVal('record_support') == true) {
							Record::create([
									'sn' => $device->sn,
									'type' => 'dev',
									'data' => '{"action":"nameedt", "name":"'.$device->name.'"}'
							]);
						}
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
						if(Globalval::getVal('record_support') == true) {
							Record::create([
									'sn' => $device->sn,
									'type' => 'dev',
									'data' => '{"action":"typeedt", "type":"'.$device->type.'"}'
							]);
						}
						$device->save();
						return $device->updated_at;
					}
					return 'FAIL';
				}
				else if ($request->input('way') == 'areaedt') {
					if($device != null) {
						$device->area = $request->input('value');
						if(Globalval::getVal('record_support') == true) {
							Record::create([
									'sn' => $device->sn,
									'type' => 'dev',
									'data' => '{"action":"areaedt", "area":"'.$device->area.'"}'
							]);
						}
						$device->save();
						return $device->updated_at;
					}
					return 'FAIL';
				}
				else if ($request->input('way') == 'dataedt') {
					if($device != null) {
						$device->data = $request->input('value');
						if(Globalval::getVal('record_support') == true) {
							Record::create([
									'sn' => $device->sn,
									'type' => 'dev',
									'data' => '{"action":"dataedt", "data":"'.$device->data.'"}'
							]);
						}
						$device->save();
						return $device->updated_at;
					}
					return 'FAIL';
				}
				else if ($request->input('way') == 'alarmedt') {
					if($device != null) {
						$device->alarmthres = $request->input('value');
						if(Globalval::getVal('record_support') == true) {
							Record::create([
									'sn' => $device->sn,
									'type' => 'dev',
									'data' => '{"action":"alarmedt", "alarm":'.$device->alarmthres.'}'
							]);
						}
						$device->save();
						return $device->updated_at;
					}
					return 'FAIL';
				}
				else if ($request->input('way') == 'owneredt') {
					if($device != null) {
						$device->owner = $request->input('value');
						if(Globalval::getVal('record_support') == true) {
							Record::create([
									'sn' => $device->sn,
									'type' => 'dev',
									'data' => '{"action":"owneredt", "owner":"'.$device->owner.'"}'
							]);
						}
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
		else if (Globalval::getVal('record_support') == true && $devopt == 'record') {
			if($request->isMethod('post')) {
				return $this->getDeviceRecord($request);
			}
			else {
				$device = Device::where('sn', $request->get('sn'))->first();
				if($device == null) {
					return redirect('devstats');
				}

				return $this->getViewWithMenus('devstats.record', $request)
								->with('page_description', $device->name)
								->with('page_title', '设备')
								->with('device', $device);
			}
		}

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

	public function videoReal(Request $request, $camopt = null) {

		if(Globalval::getVal('video_support') == false) {
			return '<h3>Video not Support !</h3>'
				   .'<p>Please setting "video_support" enable on Database.<br>'
				   .'<b>Warning:</b> You can excute "<i>php artisan video:support enable</i>" on cmdline!</p>';
		}

		if($request->isMethod('post')) {
			if($camopt == 'camedt') {
				$device = Device::where('sn', $request->input('sn'))->first();
				if($device != null) {
					$device->name = $request->input('name');
					if(Globalval::getVal('record_support') == true) {
						Record::create([
								'sn' => $device->sn,
								'type' => 'dev',
								'data' => '{"action":"nameedt", "name":"'.$device->name.'"}'
						]);
					}
					$device->save();
					return 'OK';
				}

				return 'FAIL';
			}
			else if($camopt == 'camdel') {
				$device = Device::where('sn', $request->input('sn'))->first();
				if($device != null) {
					if(Globalval::getVal('record_support') == true) {
						Record::create([
								'sn' => $device->sn,
								'type' => 'dev',
								'data' => 'delete'
						]);
					}

					if(Globalval::getVal('matrix') == 'raspberrypi') {
						$data = json_decode($device->data);
						if(isset($data->hls_enable) && $data->hls_enable == 'true') {
							DeviceController::delEasydarwinHLS($request->input('sn'));
						}
	
						if(isset($data->rtsp_enable) && $data->rtsp_enable == 'true') {
							DeviceController::delEasydarwinRTSP($request->input('sn'));
						}
	
						if(isset($data->storage_enable) && $data->storage_enable == 'true') {
							DeviceController::delFFmpegStorage($request->input('sn'));
						}
	
						if(isset($data->rtmp_enable) && $data->rtmp_enable == 'true') {
							DeviceController::delFFmpegRTMP($request->input('sn'));
						}
					}

					$device->delete();
					return 'OK';
				}

				return 'FAIL';
			}
			else if($camopt == 'camadd') {
				$sn = $request->input('sn');
				$stream_type = $request->input('type');
				$url = $request->input('url');
				if($stream_type == 'rtsp') {
					if (Globalval::getVal('video_rtmp_default_enable') == 'true') {
						DeviceController::addFFmpegRTMP($sn, $url);
					}

					if (Globalval::getVal('video_storage_default_enable') == 'true') {
						DeviceController::addFFmpegStorage($sn, $url);
					}

					if (Globalval::getVal('video_hls_default_enable') == 'true') {
						DeviceController::addEasydarwinHLS($sn, $url, 0);
					}

					if (Globalval::getVal('video_rtsp_default_enable') == 'true') {
						DeviceController::addEasydarwinRTSP($sn, $url);
					}

					return 'OK';
				}
				else if ($stream_type == 'hls' || $stream_type == 'rtmp') {
					$data = ['protocol' => $stream_type, 'url' => $url];

					if((Globalval::getVal('matrix') == 'raspberrypi' && strpos($sn, '_') !== 0)
						|| (Globalval::getVal('matrix') == 'server' && strpos($sn, '_') === 0)) {
						Device::create([
								'sn' => $sn,
								'name' => $sn,
								'type' => 1,
								'attr' => 3,
								'data' => json_encode($data),
						]);
	
						if(Globalval::getVal('record_support') == true) {
							Record::create([
									'sn' => $sn,
									'type' => 'dev',
									'data' => 'add'
							]);
						}
					}

					return 'OK';
				}

				return 'FAIL';
			}
			else if($camopt == 'camset') {
				$action = $request->input('action');
				$sn = $request->input('sn');
				$check = $request->input('check');
				$url = '';

				$camdev = Device::where('sn', $sn)->first();
				if ($camdev) {
					$data = json_decode($camdev->data);
					switch($action) {
					case 'rtmp':
						$data->rtmp_enable = $check;
						if ($data->rtmp_enable == 'true') {
							DeviceController::addFFmpegRTMP($camdev->sn, $data->source);
							$url = 'rtmp://'.$data->host.':'.$data->rtmp_port.$data->rtmp_path;
						}
						else {
							DeviceController::delFFmpegRTMP($camdev->sn);
							$action = 'none';
						}

						$camdev->data = json_encode($data);
						$camdev->save();
						break;

					case 'hls':
						$data->hls_enable = $check;
						$camdev->data = json_encode($data);
						$camdev->save();
						break;

					case 'rtsp':
						$data->rtsp_enable = $check;
						$camdev->data = json_encode($data);
						$camdev->save();
						break;

					case 'storage':
						$data->storage_enable = $check;
						if ($data->storage_enable == 'true') {
							DeviceController::addFFmpegStorage($camdev->sn, $data->source);
						}
						else {
							DeviceController::delFFmpegStorage($camdev->sn);
						}

						$camdev->data = json_encode($data);
						$camdev->save();
						break;
					}
				}

				return json_encode([
						'action' => $action,
						'sn' => $sn,
						'check' => $check,
						'url' => $url,
				]);
			}
			else if($camopt == 'camattr') {
				$sns = json_decode($request->input('sns'));
				$camdevs = Device::whereIn('sn', $sns)->get();
				$camdatas = [];
				foreach ($camdevs as $camdev) {
					$data = json_decode($camdev->data);
					$camdatas[$camdev->sn] = $data;
				}

				return json_encode($camdatas);
			}
			else if($camopt == 'camctrl') {
			    DeviceController::sendFFmpegCtrl($request->input('sn'), $request->input('action'));
			}
		}
		else if($camopt == 'camadd') {
			return $this->getViewWithMenus('videoreal.camadd', $request)
						->with('page_title', '摄像头');
		}

		$gp = Input::get('page');	//From URL

		$edtypes = $request->input('edtypes');
		if($edtypes) {
			$vedfiles = $this->getAllVideoNames(null, $edtypes);
		}
		else {
			$vedfiles = $this->getAllVideoNames();
		}

		$pagetag = new PageTag(6, 5, count($vedfiles['video_files']), $gp?$gp:1);
		$vedfiles['video_files'] = array_slice($vedfiles['video_files'], ($pagetag->getPage()-1)*6, 6);

		if($request->isMethod('post')) {
			if($request->input('way') == 'videolist') {
				return view('videoreal.videolist')
						->with('request', $request)
						->with('pagetag', $pagetag)
						->with($vedfiles);
			}
		}

		return $this->getViewWithMenus('videoreal', $request)
						->with('pagetag', $pagetag)
						->with('video_rand', $this->getRandVideoName())
						->with($vedfiles);
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
				else if(Globalval::getVal('record_support') == true) {
					Record::create([
							'sn' =>  Auth::user()->sn,
							'type' => 'user',
							'data' => '{"action":"msgadd", "content":"'.$content.'"}'
					]);
				}

				$msgboards = Msgboard::orderBy('updated_at', 'asc');
				if(count($msgboards->get()) < 6) {
					Msgboard::create(['bgcolor' => $color, 'content' => $content]);
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

	protected function getDevicesWithPage($area = null, $attr = null, $page = null, $devices = null) {
		/* Device lists from page */
		$gp = Input::get('page');	//From URL
		if($page) {
			$gp = $page;
		}

		if($devices == null) {
			$devices = Device::where('attr', '!=', 3);	//All devices, except camera
		}

		if($area != null) {
			$devices = $devices->where('area', $area);
		}

		if($attr != null) {
			$devices = $devices->where('attr', $attr);
		}

		$pagetag = new PageTag(3, 3, $devices->count(), $gp?$gp:1);
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

	private function getDeviceRecord($request, $samnum = 20, $start_time = null, $end_time = null) {
		$sn = $request->get('sn');
		$num = $request->get('num');
		if ($num) {
			$samnum = $num;
		}

		$jstart = $request->get('start_time');
		if ($jstart) {
			$start_time = $jstart;
		}

		$jend = $request->get('end_time');
		if ($jend) {
			$end_time = $jend;

			$end_only_day = date('Y-m-d', strtotime($end_time));
			$end_only_time = date('H:i:s', strtotime($end_time));

			if (strstr($end_time, $end_only_day) === false
				&& strstr($end_time, date('H:i', strtotime($end_time))) !== false) {
				$end_time = date('Y-m-d', strtotime($start_time)).' '.$end_only_time;
			}
		}

		$device = Device::where('sn', $sn)->first();
		if($device == null) {
			return null;
		}

		$before_start = $start_time;
		$before_end = $end_time;

		$carbon_now = Carbon::now(); //new Carbon('2016-11-21 11:59:59');
		$now_day = date('Y-m-d', strtotime($carbon_now));
		$now_time = date('H:i:s', strtotime($carbon_now));

		($start_time == null) && $start_time = new Carbon($now_day.' 00:00:00');
		($end_time == null) && $end_time = $carbon_now;

		if ($before_start == null) {
			if ($before_end != null) {
				$carbon_now = new Carbon($end_time);
			}

			if ($now_time < '12:00:00') {
				$carbon_before = $carbon_now->subDay();
				$before_day = date('Y-m-d', strtotime($carbon_before));

				$start_time = new Carbon($before_day.' 00:00:00');
				$end_time = new Carbon($before_day.' 23:59:59');
			}
		}

		$records = Record::where('sn', $sn)
							->where('type', 'dev')
							->whereBetween('updated_at', [$start_time, $end_time])
							->orderBy('updated_at', 'desc')
							->get();

		$disnum = (int)round($records->count()/$samnum);
		($disnum < 1) && $disnum = 1;

		$chartdata = array();
		$charttitle = array();
		for ($index=0; $index<$records->count(); $index+=$disnum) {
			$record = $records[$index];

			$xydata = $this->getRecordData($device, $record);
			if($xydata) {
				foreach ($xydata['y'] as $yk => $yv) {
					if(!isset($chartdata[$yk])) {
						$chartdata[$yk] = array();
						$charttitle[$yk] = $xydata['ytitle'][$yk];
					}
					array_push($chartdata[$yk], ['x' => $xydata['x'], 'y' => $yv]);
				}
			}
		}

		if(!count($chartdata)) {
			return null;
		}

		return json_encode([
					'data' => $chartdata,
					'title' => $charttitle,
					'count' => ['samnum' => $samnum, 'totalnum' => $records->count()],
					'timeline' => [
							'start' => date('Y-m-d H:i:s', strtotime($start_time)),
							'end' => date('Y-m-d H:i:s', strtotime($end_time))
					]
				]);
	}

	public function getRecordData($device, $record) {
		switch ($device->type) {
		case 2: //温湿度
			$jd = json_decode($record->data);
			if(isset($jd->value)) {
				$jv = explode('/', $jd->value);
				return [
					'x' => date($record->updated_at),
					'y' => ['Temp' => $jv[0], 'Humi' => $jv[1]],
					'ytitle' => ['Temp' => '温度 / ℃', 'Humi' => '湿度 / %']
				];
			}
			break;

		case 3: //光照
			$jd = json_decode($record->data);
			if(isset($jd->value)) {
				return [
						'x' => date($record->updated_at),
						'y' => ['Illumi' => $jd->value],
						'ytitle' => ['Illumi' => '光照 / lux']
				];
			}
			break;

		case 7: //氨气
			$jd = json_decode($record->data);
			if(isset($jd->value)) {
				return [
					'x' => date($record->updated_at),
					'y' => ['Ammonia' => $jd->value],
					'ytitle' => ['Ammonia' => '氨气 / ppm']
				];
			}
			break;

		case 9: //硫化氢
			$jd = json_decode($record->data);
			if(isset($jd->value)) {
				return [
						'x' => date($record->updated_at),
						'y' => ['Hydrothion' => $jd->value],
						'ytitle' => ['Hydrothion' => '硫化氢 / ppm']
				];
			}
			break;

		case 13: //CO2
			$jd = json_decode($record->data);
			if(isset($jd->value)) {
				return [
					'x' => date($record->updated_at),
					'y' => ['CO2' => $jd->value],
					'ytitle' => ['CO2' => 'CO2 / ppm']
				];
			}
			break;
		}

		return null;
	}

	public function getAllVideoNames($selnames = null, $edtypes = 'rtmp|storage|none') {

		if(Globalval::getVal('video_support') == false) {
			return null;
		}

		$typesarr = explode('|', $edtypes);
		foreach ($typesarr as $ti => $tarr) {
			$typesarr[$ti] = trim($tarr);
		}

		$video_file_names = array();
		$dbcams = Device::where('attr', 3);

		//Using by easydarwin
		$getpos = array_search('m3u8', $typesarr);
		$checkpos = array_search('rtmp', $typesarr);
		if( $getpos !== false) {
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
						$data->hls_enable = Globalval::getVal('video_hls_default_enable');

						$user = User::where('name', 'root')->first();
						if (!$user) {
							$user = User::query()->first();
						}

						Device::create([
		        				'sn' => $sn,
		        				'name' => $name,
		        				'type' => 1,
		        				'attr' => 3,
		        				'data' => json_encode($data),
		        				'owner' => $user->sn,
		        		]);

						if(Globalval::getVal('record_support') == true) {
							Record::create(['sn' => $sn, 'type' => 'dev', 'data' => 'add']);
						}
					}
					else {
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

						$sdppos = array_search('sdp', $typesarr);
						$rtmppos = array_search('rtmp', $typesarr);
						if (($sdppos !== false
								&& isset($data->rtsp_port) 
								&& isset($data->rtsp_path))
							|| ($rtmppos !== false
								&& isset($data->rtmp_port)
								&& isset($data->rtmp_path))) {}
						else {
							$dbcams = $dbcams->where('sn', '!=', $sn);
						}
					}

					//Select by names
					if($selnames != null && count($selnames) > 0) {
						foreach ($selnames as $selname) {
							if ($selname == $sn) {
								if($checkpos !== false && $checkpos < $getpos) {
									break;
								}

								$video_file_names[$sn] = [ 'id' => $sn,
										'type' => 'm3u8',
										'name' => $name,
										'url' => 'http://'.$data->host.':'.$data->hls_port.$data->hls_path ];
								break;
							}
						}

						continue;
					}

					if($checkpos !== false && $checkpos < $getpos) {
						continue;
					}

					$video_file_names[$sn] = [ 'id' => $sn,
							'type' => 'm3u8',
						  	'name' => $name,
							'url' => 'http://'.$data->host.':'.$data->hls_port.$data->hls_path ];
				}
			}
		}

		//Using by easydarwin
		$getpos = array_search('sdp', $typesarr);
		if($getpos !== false) {
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
						if($reqarr['host'] != '127.0.0.1' || $reqarr['host'] != 'localhost') {
							$data->host = $reqarr['host'];
						}
						$data->rtsp_port = $reqarr['port'];
						$data->rtsp_path = $reqarr['path'];
						$data->rtsp_enable = Globalval::getVal('video_rtsp_default_enable');
	
						$user = User::where('name', 'root')->first();
						if (!$user) {
							$user = User::query()->first();
						}

						Device::create([
								'sn' => $sn,
								'name' => $name,
								'type' => 1,
								'attr' => 3,
								'data' => json_encode($data),
								'owner' => $user->sn,
						]);

						if(Globalval::getVal('record_support') == true) {
							Record::create(['sn' => $sn, 'type' => 'dev', 'data' => 'add']);
						}
					}
					else {
						$name = $camdev->name;

						$data = json_decode($camdev->data);
						$data->protocol = 'rtsp';

						$reqarr = parse_url($session->url);
						$data->rtsp_port = $reqarr['port'];
						$data->rtsp_path = $reqarr['path'];

						$camdev->data = json_encode($data);
						$camdev->save();

						$rtmppos = array_search('rtmp', $typesarr);
						if ($rtmppos !== false
							&& isset($data->rtmp_port)
							&& isset($data->rtmp_path)) {}
						else {
							$dbcams = $dbcams->where('sn', '!=', $sn);
						}
					}

					//Select by names
					if($selnames != null && count($selnames) > 0) {
						foreach ($selnames as $selname) {
							if ($selname == $sn) {
								$video_file_names[$sn] = [ 'id' => $sn,
										'type' => 'sdp',
										'name' => $name,
										'url' => 'rtsp://'.$data->host.':'.$data->rtsp_port.$data->rtsp_path ];
								break;
							}
						}

						continue;
					}

					$video_file_names[$sn] = [ 'id' => $sn,
							'type' => 'sdp',
							'name' => $name,
							'url' => 'rtsp://'.$data->host.':'.$data->rtsp_port.$data->rtsp_path ];
				}
			}
		}

		//Using by nodejs
		$getpos = array_search('rtmp', $typesarr);
		$checkpos = array_search('m3u8', $typesarr);
		if($getpos !== false) {
			$ffjson = json_decode(DeviceController::getFFmpegRTMPList());
			if($ffjson) {
				$pushlist = array();
				foreach ($ffjson as $ffcam) {
					if($ffcam->streamtype == 'local') {
						$sn = $ffcam->name;
						$name = $sn;
	
						//Camera info match with DB
						$camdev = Device::where('sn', $sn)->first();
						if($camdev == null) {
							$data = new \stdClass();
							$data->protocol = 'rtsp';
							$data->source = $ffcam->source;
							$data->host = $_SERVER["SERVER_ADDR"]; //Globalval::getVal('hostaddr');
							$data->rtmp_port = $ffcam->rtmp_port;
							$data->rtmp_path = $ffcam->rtmp_path;
							$data->rtmp_enable = 'true';
							$data->storage_enable = Globalval::getVal('video_storage_default_enable');
	
							$user = User::where('name', 'root')->first();
							if (!$user) {
								$user = User::query()->first();
							}
		
							if(strpos($sn, '_') !== 0) {
								Device::create([
										'sn' => $sn,
										'name' => $name,
										'type' => 1,
										'attr' => 3,
										'data' => json_encode($data),
										'owner' => $user->sn,
								]);
			
								if(Globalval::getVal('record_support') == true) {
									Record::create(['sn' => $sn, 'type' => 'dev', 'data' => 'add']);
								}
							}
						}
						else {
							$name = $camdev->name;
	
							$data = json_decode($camdev->data);
							$data->host = $_SERVER['SERVER_ADDR'];
							$data->rtmp_port = $ffcam->rtmp_port;
							$data->rtmp_path = $ffcam->rtmp_path;
							$data->rtmp_enable = 'true';
	
							$camdev->data = json_encode($data);
							$camdev->save();
	
							$dbcams = $dbcams->where('sn', '!=', $sn);
						}
	
						//Select by names
						if($selnames != null && count($selnames) > 0) {
							foreach ($selnames as $selname) {
								if ($selname == $sn) {
									if($checkpos !== false && $checkpos < $getpos) {
										break;
									}
	
									$video_file_names[$sn] = [
									    'id' => $sn,
									    'type' => 'rtmp',
									    'name' => $name,
									    'url' => 'rtmp://'.$data->host.':'.$data->rtmp_port.$data->rtmp_path
									];
									break;
								}
							}
	
							continue;
						}
	
						if($checkpos !== false && $checkpos < $getpos) {
							continue;
						}
	
						$video_file_names[$sn] = [
						    'id' => $sn,
						    'type' => 'rtmp',
						    'name' => $name,
						    'url' => 'rtmp://'.$data->host.':'.$data->rtmp_port.$data->rtmp_path
						];
					}
					else if(Globalval::getVal('matrix') == 'raspberrypi' && $ffcam->streamtype == 'server') {
						array_push($pushlist, ['name' => $ffcam->name, 'url' => $ffcam->url]);
					}
				}

				if (count($pushlist) > 0) {
					DeviceController::pushRTMPStreamListToServer(json_encode($pushlist));
				}
			}
		}
		
		$getpos = array_search('rtsp', $typesarr);
		if($getpos !== false) {
            //Camera info match with DB
            $camdevs = Device::where('type', 1)->get();

            foreach ($camdevs as $camdev) {
                $campro = json_decode($camdev->data);
                if ($campro && $campro->protocol == 'rtsp') {
                    $video_file_names[$camdev->sn] = [
                        'id' => $camdev->sn,
                        'type' => 'rtsp',
                        'name' => $camdev->sn,
                        'url' => $campro->source
                    ];
                }
            }
		}

		$getpos = array_search('storage', $typesarr);
		$checkpos = array_search('none', $typesarr);
		if($getpos !== false) {
			$sdjson = json_decode(DeviceController::getFFmpegStorageList());
			if($sdjson) {
				foreach ($sdjson as $sdm4) {
					$sn = $sdm4->name;
					$name = $sn;

					$camdev = Device::where('sn', $sn)->first();
					if($camdev == null) {
						$data = new \stdClass();
						$data->protocol = $sdm4->protocol;
						$data->source = $sdm4->source;
						$data->host = Globalval::getVal('hostaddr');
						$data->storage_path = $sdm4->storage_path;
						$data->storage_enable = 'true';

						$user = User::where('name', 'root')->first();
						if (!$user) {
							$user = User::query()->first();
						}

						Device::create([
								'sn' => $sn,
								'name' => $name,
								'type' => 1,
								'attr' => 3,
								'data' => json_encode($data),
								'owner' => $user->sn,
						]);
					}
					else {
						$name = $camdev->name;

						$data = json_decode($camdev->data);
						$data->source = $sdm4->source;
						$data->storage_path = $sdm4->storage_path;
						$data->storage_enable = 'true';

						$camdev->data = json_encode($data);
						$camdev->save();
	
						$dbcams = $dbcams->where('sn', '!=', $sn);
					}

					if ($checkpos !== false && !isset($video_file_names[$sn])) {
						$video_file_names[$sn] = [
								'id' => $sn,
								'type' => 'none',
								'name' => $name,
								'url' => ''
						];
					}
				}
			}
		}

		if($selnames == null) {
			foreach ($dbcams->get() as $dbcam) {
				$data = json_decode($dbcam->data);
				if(isset($data->protocol) && isset($data->source) && $data->protocol == 'rtsp') {
					if(parse_url($data->source)['host'] == '127.0.0.1'
						|| parse_url($data->source)['host'] == 'localhost') {
						$dbcam->delete();
					}
					else {
						foreach ($typesarr as $ti) {
							if($ti == 'm3u8' && $data->hls_enable == 'true') {
								DeviceController::addEasydarwinHLS($dbcam->sn, $data->source, 0);

								if(isset($data->host)
									&& isset($data->hls_port)
									&& isset($data->hls_path)) {

									$video_file_names[$dbcam->sn] = [
											'id' => $dbcam->sn,
											'type' => 'm3u8',
											'name' => $dbcam->name,
											'url' => 'http://'
														.$data->host
														.':'
														.$data->hls_port
														.$data->hls_path
									];
								}
							}

							if($ti == 'sdp' && $data->rtsp_enable == 'true') {
								DeviceController::addEasydarwinRTSP($dbcam->sn, $data->source);

								if(isset($data->host)
									&& isset($data->rtsp_port)
									&& isset($data->rtsp_path)) {

									$video_file_names[$dbcam->sn] = [
											'id' => $dbcam->sn,
											'type' => 'sdp',
											'name' => $dbcam->name,
											'url' => 'rtsp://'
														.$data->host
														.':'
														.$data->rtsp_port
														.$data->rtsp_path
									];
								}
							}

							if($ti == 'rtmp') {
								$checkpos = array_search('none', $typesarr);
								if(isset($data->rtmp_enable) && $data->rtmp_enable == 'true') {
									DeviceController::addFFmpegRTMP($dbcam->sn, $data->source);
	
									if(isset($data->host)
										&& isset($data->rtsp_port)
										&& isset($data->rtsp_path)) {
	
										$video_file_names[$dbcam->sn] = [
												'id' => $dbcam->sn,
												'type' => 'rtmp',
												'name' => $dbcam->name,
												'url' => 'rtmp://'
															.$data->host
															.':'
															.$data->rtmp_port
															.$data->rtmp_path
										];
									}
								}
								else if($checkpos !== false){
									$video_file_names[$dbcam->sn] = [
											'id' => $dbcam->sn,
											'type' => 'none',
											'name' => $dbcam->name,
											'url' => ''
									];
								}
							}

							if($ti == 'storage' && $data->storage_enable == 'true') {
								DeviceController::addFFmpegStorage($dbcam->sn, $data->source);
							}
						}
					}
				}
				else if(isset($data->protocol) && $data->protocol == 'hls') {
					$video_file_names[$dbcam->sn] = [
							'id' => $dbcam->sn,
							'type' => 'm3u8',
							'name' => $dbcam->name,
							'url' => $data->url
					];
				}
				else if(array_search('rtmp', $typesarr) !== false
						&& isset($data->protocol)
						&& $data->protocol == 'rtmp') {
					$video_file_names[$dbcam->sn] = [
							'id' => $dbcam->sn,
							'type' => 'rtmp',
							'name' => $dbcam->name,
							'url' => $data->url
					];
				}
			}
		}

		$getpos = array_search('mp4', $typesarr);
		if($getpos !== false && ($selnames == null || count($video_file_names) == 0)) {
			foreach ($this->getStorageVideoNames($selnames) as $storagevideo) {
				array_push($video_file_names, $storagevideo);
			}
		}

		$outvideos = array();
		foreach ($video_file_names as $video_file_name) {
			array_push($outvideos, $video_file_name);
		}

		return ['video_files' => $outvideos, 'edtypes' => $edtypes];
	}

	public function getStorageVideoNames($selnames = null) {
		$video_file_names = array();
		$camvideos = array();

		$camsns = DB::table('devices')->where('type', 1)->select('sn')->get();
		foreach ($camsns as $camsn) {
			array_push($camvideos, $camsn->sn.'.mp4');
		}

		$video_files = Storage::files('/public/video');
		$video_ktfiles = [];
		foreach ($video_files as $video_file) {
			$video_ktfiles[Storage::lastModified($video_file)] = $video_file;
		}
		krsort($video_ktfiles);

		foreach ($video_ktfiles as $video_file) {
			$videohost = Globalval::getVal('hostaddr');
			$video_file_path_array = explode('/', $video_file);
			$name = end($video_file_path_array);

			if (array_search($name, $camvideos) !== false
				|| ($selnames && array_search($name, $selnames) === false)) {
				continue;
			}

			array_push($video_file_names, [
					'id' => preg_replace('/[^0-9]/', '', $name),
					'type' => 'mp4',
					'name' => $name,
					'url' => 'http://'.$videohost.':8380/video/'.$name
			]);
		}

		return $video_file_names;
	}

	protected function getRandVideoName($names = null, $edtypes = 'rtmp') {

		if(Globalval::getVal('video_support') == false) {
			return null;
		}

		$video_file_names = $this->getAllVideoNames($names, $edtypes);
		$video_file_names = $video_file_names['video_files'];
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
    