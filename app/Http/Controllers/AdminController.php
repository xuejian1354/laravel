<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
	private $data = Array();
	
	function __construct() {
		$this->data['tasks'] = [
				[
						'name' => 'Design New Dashboard',
						'progress' => '87',
						'color' => 'danger'
				],
				[
						'name' => 'Create Home Page',
						'progress' => '76',
						'color' => 'warning'
				],
				[
						'name' => 'Some Other Task',
						'progress' => '32',
						'color' => 'success'
				],
				[
						'name' => 'Start Building Website',
						'progress' => '56',
						'color' => 'info'
				],
				[
						'name' => 'Develop an Awesome Algorithm',
						'progress' => '12',
						'color' => 'success'
				]
		];
	}
	
	public function index() {

		return $this->curInfo();
	}
	
	public function curInfo() {
		return view('curinfo')
				->with($this->data)
				->with('page_title', '当前信息')
				->with('page_description', '主页面实时刷新，显示新的状态');
	}

	public function areaCtrl() {
		return view('areactrl')
				->with($this->data)
				->with('page_title', '场景监控');
	}

	public function devStats() {
		return view('devstats')
				->with($this->data)
				->with('page_title', '设备状态');
	}

	public function videoReal() {
		return view('videoreal')
				->with($this->data)
				->with('page_title', '视频图像');
	}

	public function alarmInfo() {
		return view('alarminfo')
				->with($this->data)
				->with('page_title', '报警提示');
	}
}
    