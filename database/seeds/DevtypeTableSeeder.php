<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\DBStatic\Devtype;

class DevtypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('devtypes')->delete();
        Devtype::create(['devtype' => '01', 'val' => '一位开关']);
        Devtype::create(['devtype' => '02', 'val' => '二位开关']);
        Devtype::create(['devtype' => '03', 'val' => '三位开关']);
        Devtype::create(['devtype' => '04', 'val' => '四位开关']);
        Devtype::create(['devtype' => '05', 'val' => '调色灯']);
        Devtype::create(['devtype' => '12', 'val' => '红外感应']);
        Devtype::create(['devtype' => '13', 'val' => '门磁']);
        Devtype::create(['devtype' => '14', 'val' => 'PM2.5检测']);
        Devtype::create(['devtype' => '21', 'val' => '红外转发']);
        Devtype::create(['devtype' => '22', 'val' => '超级按钮']);
        Devtype::create(['devtype' => '31', 'val' => '灯开关']);
        Devtype::create(['devtype' => '32', 'val' => '投影仪']);
        Devtype::create(['devtype' => '33', 'val' => '空调']);
        Devtype::create(['devtype' => '34', 'val' => '窗帘']);
        Devtype::create(['devtype' => '35', 'val' => '门禁锁']);
        Devtype::create(['devtype' => 'F0', 'val' => 'PM2.5检测转红外']);
        Devtype::create(['devtype' => 'F1', 'val' => '插座']);
    }
}
