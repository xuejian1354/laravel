<?php

use Illuminate\Database\Seeder;
use App\Record;
use App\User;
use App\Action;
use App\Http\Controllers\Controller;
use App\Globalval;

class RecordTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	if(count(Record::all()) == 0)
    	{
    		$root = User::where('name', 'root')->firstOrFail();
    		
    		foreach (Action::all() as $test_action) {
    			Record::create([
    					'sn' => Controller::getRandNum(),
    					'content' => '"'.Globalval::getVal('title').' "测试'.$test_action->content.'记录',
    					'usersn' => $root->sn,
    					'action' => $test_action->id,
    					'optnum' => Controller::getRandHex($root->email.$test_action->id),
    					'data' => null,
    			]);
    		}
    	}
    }
}
