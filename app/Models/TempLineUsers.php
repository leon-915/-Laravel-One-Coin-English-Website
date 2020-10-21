<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class TempLineUsers extends Model
{
    protected $table='temp_line_users';

    public $timestamps = "true";

    protected $fillable = [
        "user_id",
        "replyToken",
        "status",
    ];
}
