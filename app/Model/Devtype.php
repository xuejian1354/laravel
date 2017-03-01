<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Devtype extends Model
{
    public function rel_attr() {
        return $this->hasOne('App\Model\Devattr', 'id', 'attr');
    }
}
