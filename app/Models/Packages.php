<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    protected $table = 'packages';

    protected $fillable =
        [
            'title', 'price', 'registration_fee', 'onepage_fee','description', 'reward_point', 'roleover_condition', 'status','paypal_plan_id','paypal_response', 'zoho_item_id',
//             'no_of_lesson_available','duration_of_lesson',
        ];
}
