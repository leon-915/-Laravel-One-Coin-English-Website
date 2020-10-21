<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentTeachers extends Model
{
    protected $table = 'student_teachers';

    protected $fillable = ['student_id','teacher_id','is_friend'];
}
