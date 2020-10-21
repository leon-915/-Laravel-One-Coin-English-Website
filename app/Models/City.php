<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "cities";

    public function state() {
        return $this->belongsTo('App\Models\State', 'state_id','id');
    }
}
