<?php

namespace App\Model\DBStatic;

use Illuminate\Database\Eloquent\Model;

class Userdetail extends Model
{
    protected $table = 'userdetails';

    protected $fillable = ['sn', 'name', 'sexuality', 
    		'people', 'num', 'grade', 'type', 'birthdate',
    		'polity', 'native', 'cellphone', 'civinum', 'address', 'qq', 'email'];
}
