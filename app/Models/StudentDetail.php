<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class StudentDetail extends Model
{
    protected $table='student_details';

    public $timestamps = "true";

    protected $fillable = [
        'user_id', 'current_package_id', 'credit_balance', 'reward_balance', 'package_end_date','created_at','updated_at', 'address' , 'city' , 'country','post_code','hide_price','client_id'
    ];
}
