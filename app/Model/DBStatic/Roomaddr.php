<?php

namespace App\Model\DBStatic;

use Illuminate\Database\Eloquent\Model;

class Roomaddr extends Model
{
    protected $table = 'roomaddrs';

    protected $fillable = ['roomaddr', 'val'];
}
