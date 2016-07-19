<?php

namespace App\Model\DBStatic;

use Illuminate\Database\Eloquent\Model;

class Academy extends Model
{
    protected $table = 'academies';

    protected $fillable = ['academy', 'val', 'academyteacher', 'otherteachers', 'text'];
}
