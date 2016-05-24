<?php

namespace App\Model\Course;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = ['sn',
                            'course',
                            'coursetype',
                            'room',
                            'divideclass',
                            'time',
                            'cycle',
                            'term',
                            'teacher',
                            'studnums',
                            'coursenums',
                            'remarks'];
}
