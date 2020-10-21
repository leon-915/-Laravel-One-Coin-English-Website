<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherRatings extends Model
{
   protected $table = 'teacher_ratings';

   protected $fillable = ['teacher_id','student_id','rating_id','ratings','lesson_booking_id','status','comments'];

   public $timestamps = "true";

    public function teacher(){
        return $this->belongsTo('App\User','teacher_id','id');
    }

    public function student(){
        return $this->belongsTo('App\User','student_id','id');
    }

    public function rating(){
        return $this->belongsTo('App\Models\RatingTypes','rating_id','id');
    }
}
