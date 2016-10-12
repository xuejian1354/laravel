<?php

use Illuminate\Database\Seeder;
use App\Devtype;

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
        Devtype::create(['id' => 0, 'name' => '未知', 'attr' => 0, 'img' => 'fa fa-question']);
        Devtype::create(['id' => 1, 'name' => '摄像头', 'attr' => 3, 'img' => 'fa fa-video-camera']);
        Devtype::create(['id' => 2, 'name' => '温度', 'attr' => 1, 'img' => 'fa fa-ticket']);
        Devtype::create(['id' => 3, 'name' => '湿度', 'attr' => 1, 'img' => 'fa fa-tint']);
        Devtype::create(['id' => 4, 'name' => '光照强度', 'attr' => 1, 'img' => 'fa fa-sun-o']);
        Devtype::create(['id' => 5, 'name' => '降雨量', 'attr' => 1, 'img' => 'fa fa-umbrella']);
        Devtype::create(['id' => 6, 'name' => '风速', 'attr' => 1, 'img' => 'fa fa-flag-checkered']);
        Devtype::create(['id' => 7, 'name' => '风向', 'attr' => 1, 'img' => 'fa fa-external-link-square']);
        Devtype::create(['id' => 8, 'name' => '氨气', 'attr' => 1, 'img' => 'fa fa-lemon-o']);
        Devtype::create(['id' => 9, 'name' => '氮气', 'attr' => 1, 'img' => 'fa fa-minus-square-o']);
        Devtype::create(['id' => 10, 'name' => '硫化氢', 'attr' => 1, 'img' => 'fa fa-square-o']);
        Devtype::create(['id' => 11, 'name' => '粉尘', 'attr' => 1, 'img' => 'fa fa-asterisk']);
        Devtype::create(['id' => 12, 'name' => '噪声', 'attr' => 1, 'img' => 'fa fa-star-half-o']);
        Devtype::create(['id' => 13, 'name' => '气压', 'attr' => 1, 'img' => 'fa fa-life-buoy']);
        Devtype::create(['id' => 14, 'name' => '二氧化碳浓度', 'attr' => 1, 'img' => 'fa fa-plus-square-o']);
        Devtype::create(['id' => 15, 'name' => '溶解氧含量', 'attr' => 1, 'img' => 'fa fa-minus-square-o']);
        Devtype::create(['id' => 16, 'name' => '氨氮含量', 'attr' => 1, 'img' => 'fa fa-circle-o-notch']);
        Devtype::create(['id' => 17, 'name' => '亚硝酸盐含量', 'attr' => 1, 'img' => 'fa fa-stop']);
        Devtype::create(['id' => 18, 'name' => '水温', 'attr' => 1, 'img' => 'fa fa-pause']);
        Devtype::create(['id' => 19, 'name' => '水PH值', 'attr' => 1, 'img' => 'fa fa-header']);
        Devtype::create(['id' => 20, 'name' => '土壤温度', 'attr' => 1, 'img' => 'fa fa-ils']);
        Devtype::create(['id' => 21, 'name' => '土壤水分', 'attr' => 1, 'img' => 'fa fa-gg']);
        Devtype::create(['id' => 22, 'name' => '土壤盐分', 'attr' => 1, 'img' => 'fa fa-dot-circle-o']);
        Devtype::create(['id' => 23, 'name' => '土壤PH值', 'attr' => 1, 'img' => 'fa fa-bars']);
        Devtype::create(['id' => 24, 'name' => '施肥机', 'attr' => 2, 'img' => 'fa fa-bookmark-o']);
        Devtype::create(['id' => 25, 'name' => '增氧机', 'attr' => 2, 'img' => 'fa fa-bookmark-o']);
        Devtype::create(['id' => 26, 'name' => '电机', 'attr' => 2, 'img' => 'fa fa-plus-square']);
        Devtype::create(['id' => 27, 'name' => '风机', 'attr' => 2, 'img' => 'fa fa-forumbee']);
        Devtype::create(['id' => 28, 'name' => '水泵', 'attr' => 2, 'img' => 'fa fa-eraser']);
        Devtype::create(['id' => 29, 'name' => '阀门', 'attr' => 2, 'img' => 'fa fa-delicious']);
        Devtype::create(['id' => 30, 'name' => '电磁阀', 'attr' => 2, 'img' => 'fa fa-codepen']);
        Devtype::create(['id' => 31, 'name' => '卷帘机', 'attr' => 2, 'img' => 'fa fa-css3']);
    }
}
