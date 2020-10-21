<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class StudentOnbreakPlans extends Model
{
    protected $table='student_onbreak_plans';

    public $timestamps = "true";

    protected $fillable = [
        "user_id",
        "package_id",
        "amount",
        "start_date",
        "end_date",
        "status",
    ];
}
