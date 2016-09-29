<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Http\Controllers\Controller;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$root = User::where('email', 'root@cullive.com')->first();

    	if($root == null) {
    		User::create([
    				'sn' => Controller::getRandNum('root@cullive.com'),
    				'name' => 'root',
    				'active' => true,
    				'email' => 'root@cullive.com',
    				'password' => bcrypt('root'),
    		]);
    	}
    	else {
    		$root->active = true;
    		$root->password = bcrypt('root');
    		$root->save();
    	}
    }
}
