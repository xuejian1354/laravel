<?php

namespace App\Model\DBStatic;

use Illuminate\Database\Eloquent\Model;

class Userrecord extends Model
{
    protected $table = 'userrecords';

    protected $fillable = ['sn', 'name', 'usersn', 'action', 'optnum', 'data'];
}
