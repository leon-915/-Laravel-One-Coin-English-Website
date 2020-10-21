<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class StudentLessonsPoints extends Model
{
    protected $table='student_lessons_level_points';

    public $timestamps = "true";

    protected $fillable = [
        'student_lesson_id',
        'lesson_booking_id',
        'level_id',
        'point_id',
        'status',
        'rating_point',
        "user_id",
        "teacher_id",
    ];

    public function point() {
        return $this->belongsTo('App\Models\OnePageLevelsPoints', 'point_id','id');
    }
    public function level() {
        return $this->belongsTo('App\Models\OnePageLevels', 'level_id','id');
    }

}

// 25-9-2019
/* ALTER TABLE public.student_lessons_level_points
    ADD COLUMN lesson_booking_id bigint;
