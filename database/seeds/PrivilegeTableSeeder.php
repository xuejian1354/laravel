<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\DBStatic\Privilege;

class PrivilegeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('privileges')->delete();
        Privilege::create(['privilege' => '1', 'val' => '课程查看']);
        Privilege::create(['privilege' => '2', 'val' => '报告填写']);
        Privilege::create(['privilege' => '3', 'val' => '申请教室']);
        Privilege::create(['privilege' => '4', 'val' => '控制教室']);
        Privilege::create(['privilege' => '5', 'val' => '管理设置']);
    }
}
