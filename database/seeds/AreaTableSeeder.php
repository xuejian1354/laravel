<?php

use Illuminate\Database\Seeder;
use App\Area;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->delete();

        Area::create(['sn' => substr(hexdec(md5(rand(1, 1000000))), 2, 6),
        		'name' => '大棚1', 'type' => '大棚', 'addr' => '',
        		'status' => '正使用', 'user' => 'root', 'owner' => 'root',
        		'remarks' => '2012年，广西农业科学院白先进院长在广西第二批“八桂学者”评审会上，作为评委听取了候选人慧云首席执行官王筱东的竞聘汇报时，他感到非常兴奋——当时白院长当时正有借助物联网技术对葡萄种植进行科研活动的计划，而慧云的智慧农业云平台正是他迫切期待的技术平台。评审会结束后，白院长当即与王筱东沟通，随后便来访慧云进一步交流达成合作。对慧云来说，2012年初落地广西，这一次“产学研”的合作意味着慧云的智慧农业能更“接地气“，更便捷地深入农田，在更懂农业的基础上给农业生产者真正需要的信息化技术。对农科院而言，依托慧云智慧农业云平台进行科学研究，无疑提高了研究的水平与成果，将生产管理标准化，同时也带来了相当可观的经济效益。']);

        Area::create(['sn' => substr(hexdec(md5(rand(1, 1000000))), 2, 6),
        		'name' => '大棚2', 'type' => '大棚', 'addr' => '', 'status' => '正使用',
        		'user' => 'root', 'owner' => 'root', 'remarks' => null]);

        Area::create(['sn' => substr(hexdec(md5(rand(1, 1000000))), 2, 6),
        		'name' => '鱼业基地', 'type' => '鱼塘', 'addr' => '淳溪镇芜太路', 
        		'status' => '正使用', 'user' => 'root', 'owner' => 'root', 
        		'remarks' => '可以现抓现吃  还可钓鱼  来时提前电话预约  因不是商家不是饭店 要准备饭菜招待的   蟹塘不会有太多人  安静  而且还有螃蟹可抓 可卖  价格都是批发市场价格']);

        Area::create(['sn' => substr(hexdec(md5(rand(1, 1000000))), 2, 6),
        		'name' => '养猪场', 'type' => '养猪场', 'addr' => '', 'status' => '正使用',
        		'user' => 'root', 'owner' => 'root', 'remarks' => null]);
    }
}
