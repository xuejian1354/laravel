<?php

namespace App\Model\DBStatic;

use Illuminate\Database\Eloquent\Model;

class Globalval extends Model
{
    protected $table = 'globalvals';

    protected $fillable = ['name', 'fieldval'];
}
