<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\DBStatic\Term;

class TermTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('terms')->delete();
        Term::create(['val' => '2009上', 'coursearrange' => false, 'coursechoose' => false]);
        Term::create(['val' => '2009下', 'coursearrange' => false, 'coursechoose' => false]);
        Term::create(['val' => '2010上', 'coursearrange' => false, 'coursechoose' => false]);
        Term::create(['val' => '2010下', 'coursearrange' => false, 'coursechoose' => false]);
        Term::create(['val' => '2011上', 'coursearrange' => false, 'coursechoose' => false]);
        Term::create(['val' => '2011下', 'coursearrange' => false, 'coursechoose' => false]);
        Term::create(['val' => '2012上', 'coursearrange' => false, 'coursechoose' => false]);
        Term::create(['val' => '2012下', 'coursearrange' => false, 'coursechoose' => false]);
        Term::create(['val' => '2013上', 'coursearrange' => false, 'coursechoose' => false]);
        Term::create(['val' => '2013下', 'coursearrange' => false, 'coursechoose' => false]);
        Term::create(['val' => '2014上', 'coursearrange' => false, 'coursechoose' => false]);
        Term::create(['val' => '2014下', 'coursearrange' => false, 'coursechoose' => false]);
        Term::create(['val' => '2015上', 'coursearrange' => false, 'coursechoose' => false]);
        Term::create(['val' => '2015下', 'coursearrange' => false, 'coursechoose' => false]);
        Term::create(['val' => '2016上', 'coursearrange' => false, 'coursechoose' => false]);
        Term::create(['val' => '2016下', 'coursearrange' => false, 'coursechoose' => false]);
    }
}
