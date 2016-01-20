<?php namespace App\Http\Controllers;

use Input,DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use App\Model\Hardware\Device;
use App\Model\Hardware\Gateway;
use Symfony\Component\Console\Helper\Table;

class DeviceController extends Controller {

	public $action = [
			'tocolreq' => '1',
			'report' => '2',
			'check' => '3',
			'respond' => '4',
			'refresh' => '5',
			'control' => '6',
			'tocolres' => '7'
	];

	public function __construct()
	{
		//$this->middleware('auth');
	}

	public function datapush()
	{
		switch (Input::get('datatype'))
		{
		case $this->action['tocolreq']:
			$content = json_decode(Input::get('key'))[0];
			return $this->tocolresToFrame($content->action, $content->random);

		case $this->action['report']:
			$content = json_decode(Input::get('key'))[0];
			$devices = $content->devices;

			$this->frameWithGateway([
					'gw_sn' => $content->gw_sn,
					'transtocol' => 'post',
					'ip' => null,
					'udp_port' => null,
					'tcp_port' => null,
					'http_url' => null
			]);

			foreach ($devices as $device)
			{
				if(count(DB::table('devices')->where('dev_sn', $device->dev_sn)->get()) > 0)
				{
					DB::table('devices')
						->where('dev_sn', $device->dev_sn)
						->update([
							'dev_type' => $device->dev_type,
							'znet_status' => $device->znet_status,
							'dev_data' => $device->dev_data,
							'gw_sn' => $content->gw_sn,
							'updated_at' => new Carbon
					]);
				}
				else
				{
					Device::create([
							'dev_sn' => $device->dev_sn,
							'name' => $device->name,
							'dev_type' => $device->dev_type,
							'znet_status' => $device->znet_status,
							'dev_data' => $device->dev_data,
							'gw_sn' => $content->gw_sn,
							'area' => '未设置',
							'ispublic' => '0',
							'owner' => 'root',
					]);
				}
			}

			return $this->tocolresToFrame($content->action, $content->random);

		case $this->action['check']:
			$content = json_decode(Input::get('key'))[0];
			return $this->tocolresToFrame($content->action, $content->random);
		}

		return "Unrecognize frame, cannot parse for it";
	}

	public function tocolresToFrame($action, $random)
	{
		$ret = [[
				'action' => $this->action['tocolres'],
				'obj' => [
						'owner' => 'server',
						'custom' => 'gateway',
				],
				'req_action' => $action,
				'random' => $random,
		]];

		return json_encode($ret);
	}

	public function frameWithGateway(array $gw)
	{
		if(count(DB::table('gateways')->where('gw_sn', $gw['gw_sn'])->get()) > 0)
		{
			DB::table('gateways')
				->where('gw_sn', $gw['gw_sn'])
				->update([
						'transtocol' => $gw['transtocol'],
						'ip' => $gw['ip'],
						'udp_port' => $gw['udp_port'],
						'tcp_port' => $gw['tcp_port'],
						'http_url' => $gw['http_url'],
						'updated_at' => new Carbon
				]);
		}
		else
		{
			Gateway::create([
					'name' => '网关'.substr($gw['gw_sn'], -4),
					'gw_sn' => $gw['gw_sn'],
					'transtocol' => $gw['transtocol'],
					'ip' => $gw['ip'],
					'udp_port' => $gw['udp_port'],
					'tcp_port' => $gw['tcp_port'],
					'http_url' => $gw['http_url'],
					'area' => '未设置',
					'ispublic' => '0',
					'owner' => 'root',
			]);
		}
	}
}

