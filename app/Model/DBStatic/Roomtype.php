<?php

namespace App\Model\DBStatic;

use Illuminate\Database\Eloquent\Model;

class Roomtype extends Model
{
    protected $table = 'roomtypes';

    protected $fillable = ['roomtype', 'val'];
}
