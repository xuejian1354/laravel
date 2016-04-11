<?php

namespace App\Model\Room;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = ['sn', 'name', 'roomtype', 'addr', 'status', 'user', 'owner', 'remarks'];
}
