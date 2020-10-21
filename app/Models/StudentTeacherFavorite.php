<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentTeacherFavorite extends Model
{
   protected $table = 'student_teacher_favorite';

   protected $fillable = ['teacher_id','student_id','is_favorite'];

   public $timestamps = "true";
}
