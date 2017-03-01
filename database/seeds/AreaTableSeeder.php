<?php

use Illuminate\Database\Seeder;
use App\Model\Area;
use App\Http\Controllers\Controller;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Area::query()->count() == 0) {
            /*
	        Area::create(['sn' => Controller::getRandNum(),
	        		'name' => '大棚1', 'type' => '大棚', 'addr' => '',
	        		'status' => '正使用', 'user' => 'root', 'owner' => 'root',
	        		'remarks' => '2012年，广西农业科学院白先进院长在广西第二批“八桂学者”评审会上，作为评委听取了候选人慧云首席执行官王筱东的竞聘汇报时，他感到非常兴奋——当时白院长当时正有借助物联网技术对葡萄种植进行科研活动的计划，而慧云的智慧农业云平台正是他迫切期待的技术平台。评审会结束后，白院长当即与王筱东沟通，随后便来访慧云进一步交流达成合作。对慧云来说，2012年初落地广西，这一次“产学研”的合作意味着慧云的智慧农业能更“接地气“，更便捷地深入农田，在更懂农业的基础上给农业生产者真正需要的信息化技术。对农科院而言，依托慧云智慧农业云平台进行科学研究，无疑提高了研究的水平与成果，将生产管理标准化，同时也带来了相当可观的经济效益。']);
            */

	        Area::create(['sn' => Controller::getRandNum(),
	        		'name' => '养猪厂1', 'type' => '养猪厂', 'addr' => '', 'status' => '正使用',
	        		'user' => 'root', 'owner' => 'root', 'remarks' => null]);

	        Area::create(['sn' => Controller::getRandNum(),
	            'name' => '养猪厂2', 'type' => '养猪厂', 'addr' => '', 'status' => '正使用',
	            'user' => 'root', 'owner' => 'root', 'remarks' => null]);
        }
    }
}
