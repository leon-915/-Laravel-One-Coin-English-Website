<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class StudentLessonsKeyword extends Model
{
    protected $table='student_lessons_keywords';

    public $timestamps = "true";

    protected $fillable = [
        "student_lesson_id",
        "lesson_booking_id",
        "keyword",
        "keyword_ja",
        "type",
        "status",
        "arp_id",
        "status_changed_booking_id",
        "user_id",
        "teacher_id",
        "is_new",
    ];

    public function topics() {
        return $this->hasMany('App\Models\StudentLessonsTopic', 'lesson_booking_id','lesson_booking_id');
    }

    public function booking() {
        return $this->hasOne('App\Models\StudentLessonsBooking', 'id','lesson_booking_id');
    }
}

// 22-9-2019
/* ALTER TABLE public.student_lessons_keywords
    ADD COLUMN status_changed_booking_id bigint;