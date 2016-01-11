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
        Consolemenu::create(['mmenu' => '课程', 'cmenu' => '查看', 'action' => 'courselist']);
        Consolemenu::create(['mmenu' => '课程', 'cmenu' => '录入', 'action' => 'courseimport']);
        Consolemenu::create(['mmenu' => '教室', 'cmenu' => '使用情况', 'action' => 'roomstats']);
        Consolemenu::create(['mmenu' => '教室', 'cmenu' => '教室控制', 'action' => 'roomctrl']);
        Consolemenu::create(['mmenu' => '设备', 'cmenu' => '状态', 'action' => 'devstats']);
        Consolemenu::create(['mmenu' => '设备', 'cmenu' => '操作', 'action' => 'devctrl']);
        Consolemenu::create(['mmenu' => '用户', 'cmenu' => '老师', 'action' => 'teacher']);
        Consolemenu::create(['mmenu' => '用户', 'cmenu' => '学生', 'action' => 'student']);
    }
}
