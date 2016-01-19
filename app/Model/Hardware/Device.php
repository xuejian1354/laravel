<?php

namespace App\Model\Hardware;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'devices';

    protected $fillable = ['dev_sn', 'name', 'dev_type', 'znet_status', 'dev_data', 'gw_sn', 'area', 'ispublic', 'owner'];
}
