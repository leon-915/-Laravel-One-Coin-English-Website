<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class StudentLessonsTasks extends Model
{
    protected $table='student_lessons_material_and_tasks';

    public $timestamps = "true";

    protected $fillable = [
        "student_lesson_id",
        "lesson_booking_id",
        "lessons_material_and_tasks_1",
        "lessons_material_and_tasks_2",
        "lessons_material_and_tasks_3",
        "lessons_tasks_1",
        "lessons_tasks_2",
        "lessons_tasks_3",
        "homework_lessons_material_and_tasks_1",
        "homework_lessons_material_and_tasks_2",
        "homework_lessons_material_and_tasks_3",
        "next_lessons_tasks_1",
        "next_lessons_tasks_2",
        "next_lessons_tasks_3",
        "user_id",
        "teacher_id",
    ];
}

// 25-9-2019
/* ALTER TABLE public.student_lessons_material_and_tasks
    ADD COLUMN lesson_booking_id bigint;