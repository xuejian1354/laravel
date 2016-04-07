<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\DBStatic\Devcmd;

class DevcmdTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('devcmds')->delete();
        Devcmd::create(['action' => '开', 'dev_type' => '01', 'data' => '01']);
        Devcmd::create(['action' => '关', 'dev_type' => '01', 'data' => '00']);
        Devcmd::create(['action' => '调色数值', 'dev_type' => '05', 'data' => '01FE80A0']);
        Devcmd::create(['action' => '报警', 'dev_type' => '11', 'data' => '01']);
        Devcmd::create(['action' => '消声', 'dev_type' => '11', 'data' => '00']);
        Devcmd::create(['action' => '获取数据', 'dev_type' => '14', 'data' => 'GDT']);
        Devcmd::create(['action' => '控制1', 'dev_type' => '21', 'data' => 'SEN01']);
        Devcmd::create(['action' => '学习1', 'dev_type' => '21', 'data' => 'LEA01']);
        Devcmd::create(['action' => '开', 'dev_type' => '31', 'data' => '01']);
        Devcmd::create(['action' => '关', 'dev_type' => '31', 'data' => '00']);
        Devcmd::create(['action' => '控制1', 'dev_type' => '32', 'data' => 'SEN01']);
        Devcmd::create(['action' => '学习1', 'dev_type' => '32', 'data' => 'LEA01']);
        Devcmd::create(['action' => '控制1', 'dev_type' => '33', 'data' => 'SEN01']);
        Devcmd::create(['action' => '学习1', 'dev_type' => '33', 'data' => 'LEA01']);
        Devcmd::create(['action' => '正转', 'dev_type' => '34', 'data' => '10']);
        Devcmd::create(['action' => '停', 'dev_type' => '34', 'data' => '00']);
        Devcmd::create(['action' => '反转', 'dev_type' => '34', 'data' => '01']);
        Devcmd::create(['action' => '开', 'dev_type' => '35', 'data' => '01']);
        Devcmd::create(['action' => '开', 'dev_type' => 'F1', 'data' => '01']);
        Devcmd::create(['action' => '关', 'dev_type' => 'F1', 'data' => '00']);
        Devcmd::create(['action' => '通用', 'dev_type' => 'FF', 'data' => '01']);
    }
}
