<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class StudentLessonsARP extends Model
{
    protected $table='student_lessons_active_recall_pairs';

    public $timestamps = "true";

    protected $fillable = [
        "student_lesson_id",
        "lesson_booking_id",
        "line_1",
        "line_2",
        "status",
        "status_changed_booking_id",
        "user_id",
        "teacher_id",
        "is_new",
    ];

    public function booking() {
        return $this->hasOne('App\Models\StudentLessonsBooking', 'id','lesson_booking_id');
    }
}

// 22-9-2019
/* ALTER TABLE public.student_lessons_active_recall_pairs
    ADD COLUMN status_changed_booking_id bigint;