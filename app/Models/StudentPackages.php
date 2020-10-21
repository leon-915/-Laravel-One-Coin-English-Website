<?php

namespace App\models;


use Illuminate\Database\Eloquent\Model;

class StudentPackages extends Model
{
    protected $table='student_packages';

    public $timestamps = "true";

    protected $fillable = [
        "user_id",
        "package_id",
        "start_date",
        "end_date",
        "price",
        "status",
        "payment_type",
        "payment_status",
        "accent_order_id",
        "transaction_id",
        "total_credits",
        "rolledover_credits",
        "consumed_credits",
        "consumed_rewards",
		"zoho_invoice_id",
    ];

    public function package() {
        return $this->belongsTo('App\Models\Packages', 'package_id','id');
    }

    public function student() {
        return $this->belongsTo('App\User','user_id','id');
    }
}
