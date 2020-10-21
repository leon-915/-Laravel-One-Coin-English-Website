<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherServices extends Model
{
    protected $table = 'teacher_services';

    protected $fillable = ['service_id','teacher_id'];
}
