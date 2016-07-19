<?php

namespace App\Model\Course;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';

    protected $fillable = ['sn', 'name', 'coursesn', 'time', 'addr', 'status', 'owner','extendinfo', 'remarks'];
}
