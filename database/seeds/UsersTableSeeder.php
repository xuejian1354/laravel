<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Http\Controllers\Controller;

class UsersTableSeeder extends Seeder
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
    				'sn' => Controller::getRandHex('root@cullive.com'),
    				'name' => 'root',
    				'email' => 'root@cullive.com',
    				'password' => bcrypt('root'),
    		        'grade' => 1, //admin
    		]);
    	}
    	else {
    		$root->grade = 1; //admin
    		$root->password = bcrypt('root');
    		$root->save();
    	}
    }
}
