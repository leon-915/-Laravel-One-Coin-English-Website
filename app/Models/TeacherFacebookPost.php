<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherFacebookPost extends Model
{
    protected $table='teacher_facebook_post';

    public $timestamps = "true";

    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'status'
    ];   

}
