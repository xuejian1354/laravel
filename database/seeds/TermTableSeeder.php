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
        Term::create(['val' => '2009上']);
        Term::create(['val' => '2009下']);
        Term::create(['val' => '2010上']);
        Term::create(['val' => '2010下']);
        Term::create(['val' => '2011上']);
        Term::create(['val' => '2011下']);
        Term::create(['val' => '2012上']);
        Term::create(['val' => '2012下']);
        Term::create(['val' => '2013上']);
        Term::create(['val' => '2013下']);
        Term::create(['val' => '2014上']);
        Term::create(['val' => '2014下']);
        Term::create(['val' => '2015上']);
        Term::create(['val' => '2015下']);
        Term::create(['val' => '2016上']);
        Term::create(['val' => '2016下']);
    }
}
