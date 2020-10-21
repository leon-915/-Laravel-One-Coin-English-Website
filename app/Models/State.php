<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = "states";

    public function cities() {
        return $this->hasMany('App\Models\City', 'state_id','id');
    }

    public function country() {
        return $this->belongsTo('App\Models\Country', 'state_id','id');
    }
}
