<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HolidaySettings extends Model
{
    protected $table = 'holiday_settings';

    protected $fillable = [
            'start_date',
            'start_time',
            'end_date',
            'end_time',
            'message_en',
            'message_ja',
            'holiday_message_display_start_date',
    ];
}
