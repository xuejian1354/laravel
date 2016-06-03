<?php

namespace App\Model\DBStatic;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'scores';

    protected $fillable = ['sn', 'score', 'usersn', 'examsn', 'remarks'];
}
