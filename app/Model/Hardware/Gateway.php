<?php

namespace App\Model\Hardware;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    protected $table = 'gateways';

    protected $fillable = ['name', 'gw_sn', 'transtocol', 'ip', 'udp_port', 'tcp_port', 'http_url', 'ws_url', 'area', 'ispublic', 'owner'];
}
