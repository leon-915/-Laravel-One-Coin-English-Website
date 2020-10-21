<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class StudentLessonsTopic extends Model
{
    protected $table='student_lessons_topic';

    public $timestamps = "true";

    protected $fillable = [
        "student_lesson_id",
        "lesson_booking_id",
        "title",
        "user_id",
        "teacher_id",
    ];
}

/* ALTER TABLE public.student_lessons_topic
    ADD COLUMN lesson_booking_id bigint;

COMMENT ON COLUMN public.student_lessons_topic.lesson_booking_id
    IS '- Student lesson booking Reference';
ALTER TABLE public.student_lessons_topic
    ADD FOREIGN KEY (lesson_booking_id)
    REFERENCES public.student_lessons_bookings (id) MATCH SIMPLE
    ON UPDATE CASCADE
    ON DELETE CASCADE; */
