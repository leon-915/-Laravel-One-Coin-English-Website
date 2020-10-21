<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableTeachers extends Model
{
    protected $table = 'available_teachers';

    protected $fillable = [
            'user_id',
    ];
}
