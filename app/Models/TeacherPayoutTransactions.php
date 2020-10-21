<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherPayoutTransactions extends Model
{
    protected $table='teacher_payout_transaction';

    public $timestamps = "true";

    protected $fillable = [
        'teacher_id',
        'amount',
        'transaction_ref_id',
        'transaction_response',
        'payout_type',
        'payout_ref_id',
        'status',
    ];

    public function teacher() {
        return $this->belongsTo('App\User', 'teacher_id','id');
    }

    public function teacherDetail() {
        return $this->belongsTo('App\Models\TeacherDetail', 'teacher_id','user_id');
    }
}
