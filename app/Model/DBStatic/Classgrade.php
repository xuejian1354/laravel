<?php

namespace App\Model\DBStatic;

use Illuminate\Database\Eloquent\Model;

class Classgrade extends Model
{
    protected $table = 'classgrades';

    protected $fillable = ['classgrade', 'academy', 'val', 'classteacher', 'assistant', 'leader', 'text'];
}
