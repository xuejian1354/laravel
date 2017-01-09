<?php

use Illuminate\Database\Seeder;
use App\Globalval;

class GlobalvalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('globalvals')->delete();
        Globalval::create(['name' => 'title', 'val' => 'RaspberryPi3']);
        Globalval::create(['name' => 'hostaddr', 'val' => 'longyuanspace.com']);
        Globalval::create(['name' => 'matrix', 'val' => 'raspberrypi']);

        Globalval::create(['name' => 'video_support', 'val' => '1']);
        Globalval::create(['name' => 'record_support', 'val' => '1']);
        Globalval::create(['name' => 'domain_permit', 'val' => '0']);

        Globalval::create(['name' => 'video_rtmp_default_enable', 'val' => 'true']);
        Globalval::create(['name' => 'video_hls_default_enable', 'val' => 'false']);
        Globalval::create(['name' => 'video_rtsp_default_enable', 'val' => 'false']);
        Globalval::create(['name' => 'video_storage_default_enable', 'val' => 'false']);
        Globalval::create([
        		'name' => 'video_storage_path',
        		'val' => '/home/www/laravel/storage/app/public/video'
        ]);
        Globalval::create(['name' => 'video_storage_timelong', 'val' => '60']);	//mins

        Globalval::create(['name' => 'node_service', 'val' => 'http://127.0.0.1:8081']);
        Globalval::create(['name' => 'easydarwin_service', 'val' => 'http://127.0.0.1:8088']);

        Globalval::create(['name' => 'easydarwin_hlslist', 'val' => '/api/getHLSList']);
        Globalval::create(['name' => 'easydarwin_rtsplist', 'val' => '/api/getRTSPList']);
        Globalval::create(['name' => 'easydarwin_addhls', 'val' => '/api/addHLSList']);
        Globalval::create(['name' => 'easydarwin_delhls', 'val' => '/api/StopHLS']);

        Globalval::create(['name' => 'node_ffrtmp', 'val' => '/ffrtmp']);
        Globalval::create(['name' => 'node_ffstorage', 'val' => '/ffstorage']);
        Globalval::create(['name' => 'node_rtmptoserver_enable', 'val' => '0']);
    }
}
