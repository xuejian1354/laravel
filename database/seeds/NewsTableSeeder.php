<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\DBStatic\News;
use App\Http\Controllers\Admin\AdminUserInfo;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(count(News::all()) == 0)
        {
	        News::create([
	        		'sn' => AdminUserInfo::genNewsSN('Welcome to ClassYun'),
	        		'title' => 'Welcome to ClassYun',
	        		'subtitle' => 'Welcome longyuan smart labrotary or classroom main console',
	        		'owner' => 'root',
	        		'allowgrade' => '1',
	        		'text' => '<h4><p>This is longyuan smart labrotary or classroom main console. We will provide more useful and interesting service. Let\'s looking forward to it !</p><p>For more details please refer to <a href="http://www.lysoc.cn">lysoc.cn</a>.<br/>OpenSource is support at <a href="https://github.com/xuejian1354?tab=repositories">github.com/xuejian1354</a>.</p><p><em>Thank you for using smartlab.</em></p></h4>'
	        ]);
        }
    }
}
