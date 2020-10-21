<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherDetail extends Model
{
    protected $table='teacher_detail';

    public $timestamps = "true";

    protected $fillable = [
        'user_id', 'nationality', 'address_line1', 'address_line2', 'city', 'zipcode', 'gender', 'dob', 'highest_education', 'major_subject', 'teaching_certificate', 'teaching_year_begun', 'japanese_ability', 'jplt_score', 'is_remote_teaching', 'hobby', 'message_en', 'message_jp', 'global_lesson_price', 'virtual_lesson_percentage', 'cafe_lesson_percentage', 'classroom_lesson_percentage', 'preferred_interview_method', 'skype_id', 'internet_connection_speed_link', 'lesson_minute_able_to_teach','state','country','is_ambassador', 'per_hour_salary', 'is_available_in_trial','google_calender_link','permission', 'can_teacher_update_lesson_record','teacher_verified', 'calendar_color', 'in_training','temporarily_unavailable', 'teaching_category','is_teacher_salary_based','coaching_certified', 'onepage_certified', 'publish_profile', 'country_code', 'kids_lesson_price', 'aspire_lesson_price', 'is_training_completed',
    ];
}
