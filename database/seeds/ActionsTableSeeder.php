<?php

use Illuminate\Database\Seeder;
use App\Action;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('actions')->delete();
        Action::create(['id' => 0, 'content' => '调试', 'img' => 'fa fa-random bg-yellow']);
        Action::create(['id' => 1, 'content' => '注册', 'img' => 'fa fa-registered bg-green']);
        Action::create(['id' => 2, 'content' => '注销', 'img' => 'fa fa-close bg-red']);
        Action::create(['id' => 3, 'content' => '登录', 'img' => 'fa fa-sign-in bg-green']);
        Action::create(['id' => 4, 'content' => '退出', 'img' => 'fa fa-sign-out bg-red']);
        Action::create(['id' => 5, 'content' => '更新', 'img' => 'fa fa-refresh bg-purple']);
        Action::create(['id' => 6, 'content' => '控制', 'img' => 'fa fa-hand-pointer-o bg-lime']);
        Action::create(['id' => 7, 'content' => '统计', 'img' => 'fa fa-pie-chart bg-olive']);
        Action::create(['id' => 8, 'content' => '导出', 'img' => 'fa fa-file-excel-o bg-orange']);
        Action::create(['id' => 9, 'content' => '导入', 'img' => 'fa fa-caret-square-o-up bg-aqua']);
    }
}
