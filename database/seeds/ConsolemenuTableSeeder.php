<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\DBStatic\Consolemenu;

class ConsolemenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('consolemenus')->delete();
        Consolemenu::create(['mmenu' => '状态', 'cmenu' => '总览', 'action' => 'status']);
        Consolemenu::create(['mmenu' => '状态', 'cmenu' => '统计', 'action' => 'analysis']);
        Consolemenu::create(['mmenu' => '教室', 'cmenu' => '查看', 'action' => 'roomstats']);
        Consolemenu::create(['mmenu' => '教室', 'cmenu' => '操作', 'action' => 'roomctrl']);
        Consolemenu::create(['mmenu' => '教室', 'cmenu' => '导入', 'action' => 'roomimport']);
        Consolemenu::create(['mmenu' => '设备', 'cmenu' => '状态', 'action' => 'devstats']);
        Consolemenu::create(['mmenu' => '设备', 'cmenu' => '设置', 'action' => 'devsetting']);
        Consolemenu::create(['mmenu' => '课程', 'cmenu' => '查看', 'action' => 'courselist']);
        Consolemenu::create(['mmenu' => '课程', 'cmenu' => '导入', 'action' => 'courseimport']);
        Consolemenu::create(['mmenu' => '用户', 'cmenu' => '管理', 'action' => 'usermanage']);
        Consolemenu::create(['mmenu' => '用户', 'cmenu' => '信息', 'action' => 'userinfo']);
    }
}
