<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\DBStatic\CourseType;
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
        Model::unguard();

        $this->call(GradeTableSeeder::class);
        $this->call(PrivilegeTableSeeder::class);
        $this->call(CycleTableSeeder::class);
        $this->call(CoursetypeTableSeeder::class);
        $this->call(ConsolemenuTableSeeder::class);
        $this->call(DevtypeTableSeeder::class);
        $this->call(DevcmdTableSeeder::class);
        $this->call(GlobalvalTableSeeder::class);
        $this->call(RoomtypeTableSeeder::class);
        $this->call(TermTableSeeder::class);
        $this->call(NewsTableSeeder::class);
        $this->call(IdgradeTableSeeder::class);
        $this->call(AcademyTableSeeder::class);
        $this->call(ClassgradeTableSeeder::class);

        if(count(DB::table('users')->where('email', 'root@loongsmart.com')->get()) == 0)
        {
	        User::create([
	        		'sn' => substr(hexdec(md5('root@loongsmart.com')), 2, 8),
	                'name' => 'root',
	                'email' => 'root@loongsmart.com',
	                'password' => bcrypt('root'),
	                'grade' => 1,
	                'privilege' => 5,
	                'area' => '未设置',
	        ]);
        }

        Model::reguard();
    }
}
