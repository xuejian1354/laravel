<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;

class Record extends Model
{
    protected $fillable = ['sn', 'type', 'data'];
}
