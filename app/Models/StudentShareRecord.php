<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class StudentShareRecord extends Model
{
    protected $table='share_student_record';

    public $timestamps = "true";

    protected $fillable = [
        "user_id",
        "email",
        "share_type"
    ];
}
