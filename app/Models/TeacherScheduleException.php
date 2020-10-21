<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherScheduleException extends Model
{
    protected $table='teacher_exception_time';

    public $timestamps = "true";

    protected $fillable = [
        'user_id',
        'from_time',
        'to_time',
        'from_date',
        'to_date',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
    ];
}
