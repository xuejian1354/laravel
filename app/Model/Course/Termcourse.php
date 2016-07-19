<?php

namespace App\Model\Course;

use Illuminate\Database\Eloquent\Model;

class Termcourse extends Model
{
    protected $table = 'termcourses';

    protected $fillable = ['term', 'classgrade', 'courses'];
}
