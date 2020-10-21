<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class StudentLessons extends Model
{
    protected $table='student_lessons';

    public $timestamps = "true";

    protected $fillable = [
        "user_id",
        "service_id",
        "available_bookings",
        "price",
        "start_date",
        "expire_date",
        "student_level_id",
        "free_lessons",
        "free_lessons_2",
        "lesson_comment",
        "show_comment_to_student",
        "last_booking_canvas_html",
        "last_booking_canvas_core",
        "last_booking_topic",
        "status",
        "student_package_id",
        "days_extend",
        "accent_order_id",
        "days_extended2",
        "rolled_over_lessons",
        "rolled_over_lessons2",
        "connected_order",
        "connected_order_date_updated",
        "transaction_id",
        "zoho_invoice_id",
    ];

    public function student() {
        return $this->belongsTo('App\User', 'user_id','id');
    }

    public function service() {
        return $this->belongsTo('App\Models\Services', 'service_id','id');
    }

    public function student_level() {
        return $this->belongsTo('App\Models\OnePageLevels', 'student_level_id','id');
    }

    public function student_level_points() {
        return $this->hasMany('App\Models\StudentLessonsPoints', 'student_level_id','id');
    }

    public function tasks() {
        return $this->hasOne('App\Models\StudentLessonsTasks', 'student_lesson_id','id');
    }

    public function arps() {
        return $this->hasMany('App\Models\StudentLessonsARP', 'student_lesson_id','id')->orderBy('id','ASC');
    }

    public function cips() {
        return $this->hasMany('App\Models\StudentLessonsCIP', 'student_lesson_id','id')->orderBy('id','ASC');
    }

    public function keywords() {
        return $this->hasMany('App\Models\StudentLessonsKeyword', 'student_lesson_id','id')->orderBy('id','ASC');
    }

    public function topics() {
        return $this->hasMany('App\Models\StudentLessonsTopic', 'student_lesson_id','id')
                    ->orderBy('lesson_booking_id','DESC');
    }

    public function last_topic() {
        return $this->hasOne('App\Models\StudentLessonsTopic', 'student_lesson_id','id')
                        ->orderBy('lesson_booking_id','DESC');
    }
}
