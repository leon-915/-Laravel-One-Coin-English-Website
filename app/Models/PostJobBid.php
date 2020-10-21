<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PostJobBid extends Model
{
    protected $table = 'job_post_bid';

    protected $fillable = ['user_id', 'job_id', 'bid_price', 'status'];

    public function teacher()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function job()
    {
        return $this->hasOne('App\Models\PostJob', 'id', 'job_id')
            ->with('student');
    }


}
