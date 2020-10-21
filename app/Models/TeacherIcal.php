<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherIcal extends Model
{
    protected $table = 'teacher_ical';

    protected $fillable = [
        'teacher_id',
        'ical_link'
    ];
}
