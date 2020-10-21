<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    protected $table = "cart";

    protected $fillable = [
        'name', 'user_id', 'service_id'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function service()
    {
        return $this->hasOne('App\Models\Services', 'id', 'service_id');
    }

}
