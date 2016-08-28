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

class AdminController extends Controller
{
	public function index(Request $request) {
		return redirect('curinfo');
	}
	
	public function curInfo(Request $request) {
		return $this->getViewWithMenus('curinfo', $request)
						->with('page_title', '当前信息')
						->with('page_description', '主页面实时刷新，显示新的状态');
	}

	public function areaCtrl(Request $request, $areaid = null) {
		return $this->getViewWithMenus('areactrl', $request)
						->with('page_title', '场景监控'.$areaid);
	}

	public function devStats(Request $request) {
		return $this->getViewWithMenus('devstats', $request)
						->with('page_title', '设备状态');
	}

	public function videoReal(Request $request) {
		return $this->getViewWithMenus('videoreal', $request)
						->with('page_title', '视频图像');
	}

	public function alarmInfo(Request $request) {
		return $this->getViewWithMenus('alarminfo', $request)
						->with('page_title', '报警提示');
	}

	public function getViewWithMenus($view = null, Request $request, $data = [], $mergeData = [])
	{
		return view($view, $data, $mergeData)
				->with('reurl', $this->getReurlArray())
				->with('console_menus', (new ConsoleMenu())->getConsleMenuLists($request->path()));
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
			$url = $url.'?'.$params;
		}
		else {
			$url = $url.$params;
		}

		return url($url);
	}
}
    