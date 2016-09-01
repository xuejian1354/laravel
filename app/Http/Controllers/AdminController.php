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
		return $this->getViewWithMenus('areactrl', $request);
	}

	public function devStats(Request $request) {
		return $this->getViewWithMenus('devstats', $request);
	}

	public function videoReal(Request $request) {
		return $this->getViewWithMenus('videoreal', $request);
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
				->with('reurl', $this->getReurlArray())
				->with('select_menus', $select_menus)
				->with('console_menus', $console_menus);
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
    