<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSchedule extends Model
{
    protected $table='teacher_available_time';

    public $timestamps = "true";

    protected $fillable = [
        'user_id',
        'from_time',
        'to_time',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
    ];

    public function teacher() {
        return $this->belongsTo('App\User', 'user_id','id');
    }
}
