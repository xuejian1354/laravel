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
    	if(DB::table('users')->where('email', 'root@cullive.com')->count() == 0)
    	{
    		User::create([
    				'sn' => Controller::getRandNum('root@cullive.com'),
    				'name' => 'root',
    				'email' => 'root@cullive.com',
    				'password' => bcrypt('root'),
    		]);
    	}
    }
}
