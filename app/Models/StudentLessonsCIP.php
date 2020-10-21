<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class StudentLessonsCIP extends Model
{
    protected $table='student_lessons_correct_incorrect_phrases';

    public $timestamps = "true";

    protected $fillable = [
        "student_lesson_id",
        "lesson_booking_id",
        "correct_phrase",
        "incorrect_phrase",
        "status",
        "status_changed_booking_id",
        "user_id",
        "teacher_id",
    ];
}

// 22-9-2019
/* ALTER TABLE public.student_lessons_correct_incorrect_phrases
    ADD COLUMN status_changed_booking_id bigint;

// Older changes
/* ALTER TABLE public.student_lessons_correct_incorrect_phrases
    ADD COLUMN lesson_booking_id bigint;

COMMENT ON COLUMN public.student_lessons_correct_incorrect_phrases.lesson_booking_id
    IS '- Student lesson booking Reference';
ALTER TABLE public.student_lessons_correct_incorrect_phrases
    ADD FOREIGN KEY (lesson_booking_id)
    REFERENCES public.student_lessons_bookings (id) MATCH SIMPLE
    ON UPDATE CASCADE
    ON DELETE CASCADE; */
