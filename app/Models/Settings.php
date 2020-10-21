<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table='admin_settings';

    protected $fillable = [
        'book_before_time',
        'cancel_before_time',
        'max_globle_lesson_price',
        'max_classroom_lesson_price_per',
        'max_vertual_lesson_price_per',
        'max_cafe_lesson_price_per',
        'admin_commision',
        'start_time',
        'end_time',
        'next_day_available_time',
        'site_title',
        'email_address',
        'onepage_certified_fee',
        'default_payment_getway',
        'asana_access_token',
        'asana_workspace_id',
        'stripe_publishable_key',
        'stripe_secret_key',
        'tax',
        'no_of_free_lesson_rating',
        'teacher_credits_rate',
        'yen_rate',
        'package_expire_reminder_days',
        'book_upto_month',
        'to_email',
        'from_email',
        'student_referred_admin_commision',
        'regular_course_rollover_precentage',
        'max_price_upto_2_year',
        'max_price_upto_4_year',
        'max_price_above_4_year',
        'kids_lesson_max_price',
        'aspire_lesson_max_price',
        'allowed_trial_lessons',
        'allowed_trial_lessons_period',
        'reset_trial_lessons',
        'booking_reminder',
    ];

    public static function getSettings($setting = null){
        if($setting){
            return static::query()->value($setting);
        } else {
            return static::first()->toArray();
        }
    }

}
