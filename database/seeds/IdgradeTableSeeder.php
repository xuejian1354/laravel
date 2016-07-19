<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\DBStatic\Idgrade;

class IdgradeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('idgrades')->delete();
        Idgrade::create(['idgrade' => '1', 'val' => '全校']);
        Idgrade::create(['idgrade' => '2', 'val' => '院系']);
        Idgrade::create(['idgrade' => '3', 'val' => '专业']);
        Idgrade::create(['idgrade' => '4', 'val' => '班级']);
        Idgrade::create(['idgrade' => '5', 'val' => '指定用户']);
    }
}
