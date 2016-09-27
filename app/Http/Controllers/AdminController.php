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

class AdminController extends Controller
{
	public function index(Request $request) {

		if($request->isMethod('get')) {
			return redirect('curinfo');
		}
	}

	public function curInfo(Request $request) {

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

	public function areaCtrl(Request $request, $areasn = null) {

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
						->with($this->getDevicesWithPage($area->sn, 2));
			}
		}

		/* View */
		return $this->getViewWithMenus('areactrl', $request)
						->with('area', $area)
						->with('areaboxes', $areaboxes)
						->with($this->getDevicesWithPage($area->sn, 2))
						->with('video_file', $this->getRandVideoName());
	}

	public function devStats(Request $request) {

		if($request->isMethod('post')) {
			if($request->input('way') == 'devlist') {
				return view('devstats.devlist')
						->with($this->getDevicesWithPage());
			}
		}

		return $this->getViewWithMenus('devstats', $request)
						->with($this->getDevicesWithPage());
	}

	public function videoReal(Request $request) {
		$gp = Input::get('page');	//From URL

		$video_files = $this->getAllVideoNames();
		$pagetag = new PageTag(6, 3, count($video_files), $gp?$gp:1);

		$video_files = array_slice($video_files, ($pagetag->getPage()-1)*6, 6);

		if($request->isMethod('post')) {
			if($request->input('way') == 'videolist') {
				return view('videoreal.videolist')
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
				if(isset($menu->isactive) && $menu->isactive == 1) {
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

	public function getAllVideoNames() {
		$video_file_names = array();

		$video_files = Storage::files('/public/video');
		foreach ($video_files as $video_file) {
			$video_file_path_array = explode('/', $video_file);
			array_push($video_file_names, end($video_file_path_array));
		}

		return $video_file_names;
	}

	protected function getRandVideoName($video_file_names = null) {
		if($video_file_names == null) {
			$video_file_names = $this->getAllVideoNames();
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
    