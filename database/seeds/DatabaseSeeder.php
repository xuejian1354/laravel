<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

    	if(count(DB::table('users')->where('email', 'root@cullive.com')->get()) == 0)
    	{
    		User::create([
    				'sn' => substr(hexdec(md5('root@cullive.com')), 2, 6),
    				'name' => 'root',
    				'email' => 'root@cullive.com',
    				'password' => bcrypt('root'),
    		]);
    	}
    }
}
