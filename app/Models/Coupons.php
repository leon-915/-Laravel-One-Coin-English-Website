<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
   protected $table = 'coupons';

   protected $fillable = ['coupon_code','discount_type','discount',
                            'to_date','from_date','status','usage_limit_per_coupon','usage_limit_per_user'];
}
