<?php

namespace App\Model\DBStatic;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = ['title', 'subtitle', 'owner', 'allowgrade', 'visitor', 'text'];
}
