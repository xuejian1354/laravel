<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\DBStatic\Academy;
use App\Model\DBStatic\Classgrade;

class ClassgradeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classgrades')->delete();
        Classgrade::create(['classgrade' => '1', 'academy' => 1, 'val' => '建筑设计1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '2', 'academy' => 1, 'val' => '建筑设计1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '3', 'academy' => 1, 'val' => '城市规划1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '4', 'academy' => 2, 'val' => '机工1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '5', 'academy' => 3, 'val' => '能源1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '6', 'academy' => 3, 'val' => '能源1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '7', 'academy' => 3, 'val' => '环境1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '8', 'academy' => 3, 'val' => '环境1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '9', 'academy' => 4, 'val' => '通信1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '10', 'academy' => 4, 'val' => '通信1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '11', 'academy' => 4, 'val' => '通信1603', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '12', 'academy' => 4, 'val' => '电子信息1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '13', 'academy' => 4, 'val' => '电子信息1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '14', 'academy' => 4, 'val' => '电子信息1603', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '15', 'academy' => 4, 'val' => '电子信息1604', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '16', 'academy' => 5, 'val' => '土木1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '17', 'academy' => 5, 'val' => '土木1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '18', 'academy' => 5, 'val' => '工管1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '19', 'academy' => 5, 'val' => '工管1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '20', 'academy' => 5, 'val' => '工程力学1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '21', 'academy' => 5, 'val' => '工程力学1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '22', 'academy' => 7, 'val' => '数学1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '23', 'academy' => 7, 'val' => '信息计算1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '24', 'academy' => 7, 'val' => '统计1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '25', 'academy' => 8, 'val' => '控制1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '26', 'academy' => 8, 'val' => '模式识别1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '27', 'academy' => 8, 'val' => '检测1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '28', 'academy' => 9, 'val' => '计算机1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '29', 'academy' => 9, 'val' => '计算机1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '30', 'academy' => 9, 'val' => '软件1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '31', 'academy' => 9, 'val' => '软件1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '32', 'academy' => 11, 'val' => '生物医学1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '33', 'academy' => 12, 'val' => '材料1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '34', 'academy' => 14, 'val' => '经济1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '35', 'academy' => 14, 'val' => '经济1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '36', 'academy' => 14, 'val' => '工商1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '37', 'academy' => 14, 'val' => '工商1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '38', 'academy' => 14, 'val' => '会计1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '39', 'academy' => 14, 'val' => '会计1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '40', 'academy' => 14, 'val' => '物流1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '41', 'academy' => 14, 'val' => '物流1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '42', 'academy' => 15, 'val' => '机电1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '43', 'academy' => 15, 'val' => '机电1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '44', 'academy' => 15, 'val' => '电气1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '45', 'academy' => 15, 'val' => '电气1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '46', 'academy' => 16, 'val' => '外语1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '47', 'academy' => 16, 'val' => '外语1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '48', 'academy' => 16, 'val' => '外语1603', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '49', 'academy' => 16, 'val' => '外语1604', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '50', 'academy' => 18, 'val' => '化工1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '51', 'academy' => 18, 'val' => '化工1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '52', 'academy' => 18, 'val' => '制药1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '53', 'academy' => 18, 'val' => '制药1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '54', 'academy' => 20, 'val' => '仪表1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '55', 'academy' => 20, 'val' => '仪表1602', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '56', 'academy' => 22, 'val' => '法学1601', 'classteacher' => 'root']);
        Classgrade::create(['classgrade' => '57', 'academy' => 22, 'val' => '法学1602', 'classteacher' => 'root']);
    }
}
