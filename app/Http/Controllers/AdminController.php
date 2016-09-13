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

class AdminController extends Controller
{
	public function index(Request $request) {
		return redirect('curinfo');
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

	public function areaCtrl(Request $request, $areaid = null) {

		/* Area */
		$area = Area::where('sn', $areaid)->first();
		if($area == null) {
			$area = Area::query()->first();
		}

		/* Box & Content */
		$areaboxes = Areabox::where('area_type', $area->type)->get();
		foreach ($areaboxes as $areabox) {
			$areabox->contents = Areaboxcontent::where('area_sn', $area->sn)->where('box_id', $areabox->id)->get();
		}

		/* View */
		return $this->getViewWithMenus('areactrl', $request)
						->with('area', $area)
						->with('areaboxes', $areaboxes)
						->with($this->getDevicesWithPage($area->sn, 2))
						->with('video_file', $this->getRandVideoName());
	}

	public function devStats(Request $request) {
		return $this->getViewWithMenus('devstats', $request)
						->with($this->getDevicesWithPage());
	}

	public function videoReal(Request $request) {
		return $this->getViewWithMenus('videoreal', $request)
						->with('video_file', $this->getRandVideoName());
	}

	public function alarmInfo(Request $request) {
		return $this->getViewWithMenus('alarminfo', $request);
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

		$devices = Device::query();	//All devices
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

	protected function getAllVideoNames() {
		$video_file_names = array();

		$video_files = Storage::files('/public/video');
		foreach ($video_files as $video_file) {
			$video_file_path_array = explode('/', $video_file);
			array_push($video_file_names, end($video_file_path_array));
		}

		return $video_file_names;
	}

	protected function getRandVideoName() {
		$video_file_names = $this->getAllVideoNames();
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
    