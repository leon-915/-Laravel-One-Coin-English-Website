<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class StudentLessonsBooking extends Model
{
    protected $table='student_lessons_bookings';

    public $timestamps = "true";

    protected $fillable = [
        "user_id",
        "teacher_id",
        "service_id",
        "location_id",
        "lession_date",
        "session_style",
        "lession_time",
        "status",
        "is_student_present",
        "lesson_duration",
        "lession_type",
        "additional_info_teacher",
        "student_skype_id",
        "location_detail",
        "teacher_earnings",
        "is_wrapped",
        "canvas_html",
        "canvas_core",
        "onepage_title",
        "completed_at",
        "booking_comments",
        "points_to_improve_comment",
        "strong_points_comment",
        "is_rated",
        "cancelled_at",
        "is_teacher_present",
        "admin_earnings",
        "total_earnings",
        "task_id",
        "onepage_level_id",
        "ca_rating",
        "fp_rating",
        "lc_rating",
        "v_rating",
        "ga_rating",
        "booking_ip",
        "is_free_lesson",
		"student_lessons_id",
        "filter_point_type",
        "accent_lesson_record_id",
        "session_started",
    ];

    public function service() {
        return $this->belongsTo('App\Models\Services', 'service_id','id');
    }

    public function tasks() {
        return $this->hasOne('App\Models\StudentLessonsTasks', 'lesson_booking_id','id');
    }

    

    public function teacher() {
        return $this->belongsTo('App\User', 'teacher_id','id');
    }

    public function student() {
        return $this->belongsTo('App\User', 'user_id','id');
    }

    public function studentDetail() {
        return $this->belongsTo('App\Models\StudentDetail', 'user_id','user_id');
    }

    public function teacherDetail() {
        return $this->belongsTo('App\Models\TeacherDetail', 'teacher_id','user_id');
    }

    public function location() {
        return $this->belongsTo('App\Models\Locations', 'location_id','id');
    }

    public function topics() {
        return $this->hasMany('App\Models\StudentLessonsTopic', 'lesson_booking_id','id');
    }

    public function lesson() {
        return $this->belongsTo('App\Models\StudentLessons', 'service_id','service_id');
    }

    public function arps() {
        return $this->hasMany('App\Models\StudentLessonsARP', 'lesson_booking_id','id')->orderBy('status','DESC');
    }

    public function cips() {
        return $this->hasMany('App\Models\StudentLessonsCIP', 'lesson_booking_id','id')->orderBy('id','ASC');
    }

    public function keywords() {
        return $this->hasMany('App\Models\StudentLessonsKeyword', 'lesson_booking_id','id')->orderBy('id','ASC');
    }
}

// 06-10-2019
/* ALTER TABLE public.student_lessons_bookings
    ADD COLUMN filter_point_type char;
