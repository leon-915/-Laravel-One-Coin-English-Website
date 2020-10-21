<?php

namespace App\models;


use Illuminate\Database\Eloquent\Model;

class StudentTransactions extends Model
{
    protected $table = 'student_transactions';

    public $timestamps = "true";

    protected $fillable = [
        "user_id",
        "provider",
        "transaction_id",
        "stripe_customer_id",
        "amount",
        "stripe_payment_method_id",
        "transaction_type",
        "transaction_type_id",
        "payment_status",
        "response", "subtotal", "discount", "one_page_fee", "coupon_code","tax",'payment_ip',
        'billing_agreement_id',
        'freshbook_invoice_id',
        'student_package_id',
        'student_lesson_id',
        'accent_order_id',
        'zoho_invoice_id',
        'discount_type',
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
