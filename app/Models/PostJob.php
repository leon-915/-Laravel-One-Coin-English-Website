<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PostJob extends Model
{
    protected $table = 'student_job_post';

    protected $fillable = ['user_id', 'title', 'subject', 'price', 'highlights', 'date', 'time', 'bid_id'];

    public function postJobBid()
    {
        return $this->hasMany('App\Models\PostJobBid', 'job_id', 'id')
            ->with('teacher')
            ->where('status', '!=', 'rejected')
            ->orderBy('id', 'desc');
    }

    public function bid()
    {
        return $this->hasOne('App\Models\PostJobBid', 'id', 'bid_id')
            ->with('teacher');
    }

    public function student()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function checkBid($job_id)
    {
        $count = PostJobBid::where('job_id', $job_id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->count();

        return $count;
    }
}
