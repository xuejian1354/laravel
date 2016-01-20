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
        Devtype::create(['devtype' => '31', 'val' => '灯开关']);
        Devtype::create(['devtype' => '32', 'val' => '投影仪']);
        Devtype::create(['devtype' => '33', 'val' => '空调']);
        Devtype::create(['devtype' => '34', 'val' => '窗帘']);
        Devtype::create(['devtype' => '35', 'val' => '门禁']);
    }
}
