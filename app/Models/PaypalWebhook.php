<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaypalWebhook extends Model
{
    protected $table = 'paypal_webhook_test';

    protected $fillable = [ 'response' ];
}
