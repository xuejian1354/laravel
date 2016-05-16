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
        Term::create(['val' => '2009上', 'coursearrange' => true, 'coursechoose' => false, 'arrangestart' => '2009-03-02', 'arrangeend' => '2009-07-03']);
        Term::create(['val' => '2009下', 'coursearrange' => true, 'coursechoose' => false, 'arrangestart' => '2009-09-07', 'arrangeend' => '2010-02-26']);
        Term::create(['val' => '2010上', 'coursearrange' => true, 'coursechoose' => false, 'arrangestart' => '2010-03-01', 'arrangeend' => '2010-07-02']);
        Term::create(['val' => '2010下', 'coursearrange' => true, 'coursechoose' => false, 'arrangestart' => '2010-09-06', 'arrangeend' => '2011-02-25']);
        Term::create(['val' => '2011上', 'coursearrange' => true, 'coursechoose' => false, 'arrangestart' => '2011-02-28', 'arrangeend' => '2011-07-01']);
        Term::create(['val' => '2011下', 'coursearrange' => true, 'coursechoose' => false, 'arrangestart' => '2011-09-05', 'arrangeend' => '2012-03-02']);
        Term::create(['val' => '2012上', 'coursearrange' => true, 'coursechoose' => false, 'arrangestart' => '2012-02-07', 'arrangeend' => '2012-06-29']);
        Term::create(['val' => '2012下', 'coursearrange' => true, 'coursechoose' => false, 'arrangestart' => '2012-09-03', 'arrangeend' => '2013-03-01']);
        Term::create(['val' => '2013上', 'coursearrange' => true, 'coursechoose' => false, 'arrangestart' => '2013-03-04', 'arrangeend' => '2013-06-28']);
        Term::create(['val' => '2013下', 'coursearrange' => true, 'coursechoose' => false, 'arrangestart' => '2013-09-02', 'arrangeend' => '2014-02-28']);
        Term::create(['val' => '2014上', 'coursearrange' => true, 'coursechoose' => false, 'arrangestart' => '2014-03-03', 'arrangeend' => '2014-06-27']);
        Term::create(['val' => '2014下', 'coursearrange' => true, 'coursechoose' => false, 'arrangestart' => '2014-09-01', 'arrangeend' => '2015-02-27']);
        Term::create(['val' => '2015上', 'coursearrange' => true, 'coursechoose' => false, 'arrangestart' => '2015-03-02', 'arrangeend' => '2015-07-03']);
        Term::create(['val' => '2015下', 'coursearrange' => true, 'coursechoose' => false, 'arrangestart' => '2015-09-07', 'arrangeend' => '2016-03-04']);
        Term::create(['val' => '2016上', 'coursearrange' => true, 'coursechoose' => false, 'arrangestart' => '2016-03-07', 'arrangeend' => '2016-07-01']);
        Term::create(['val' => '2016下', 'coursearrange' => true, 'coursechoose' => false, 'arrangestart' => '2016-09-05', 'arrangeend' => '2017-02-03']);
    }
}
