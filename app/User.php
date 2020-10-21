<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\TeacherSchedule;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'user_type','firstname', 'lastname','firstname_ja', 'lastname_ja', 'contact_no', 'status', 'profile_image', 'step2_verification_token','skype_name','line_token', 'line_reply_token', 'asana_project_id','send_line_notifications','stripe_token','stripe_customer_id',
        'freshbook_api_url',
        'freshbook_token',
        'paypal_email',
        'referral_code',
        'used_referral_code',
        'referred_by',
        'last_login_at',
        'last_login_ip',
        'is_registerfee_paid',
        'onepage_start_date',
        'onepage_end_date',
        'billing_agreement_id',
        'billing_agreement_response',
        'accent_user_id',
        'student_level_id',
        'zoho_user_id',
        'nationality',
        'message_en',
        'audio_attachment',
        'zoho_user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'last_login_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function details() {
        if($this->user_type == 'student'){
            return $this->hasOne('App\Models\StudentDetail', 'user_id','id');
        } elseif($this->user_type == 'teacher') {
            return $this->hasOne('App\Models\TeacherDetail', 'user_id','id');
        }
    }

    public function schedule() {
        if($this->user_type == 'teacher') {
            return $this->hasMany('App\Models\TeacherSchedule', 'user_id','id');
        } else {
            return array();
        }
    }

    public function locations() {
        if($this->user_type == 'teacher') {
            return $this->hasMany('App\Models\TeacherLocations', 'user_id','id');
        } else {
            return array();
        }
    }

    public function excptionSchedule() {
        if($this->user_type == 'teacher') {
            return $this->hasMany('App\Models\TeacherScheduleException', 'user_id','id');
        } else {
            return array();
        }
    }

    public function attachements() {
        if($this->user_type == 'teacher') {
            return $this->hasMany('App\Models\TeacherAttachment', 'user_id','id');
        } else {
            return array();
        }
    }

    public function sendPasswordResetNotification($token) {
        $this->notify(new Notifications\ResetPassword($token));
        //$this->notify(new Notifications\AdminResetPassword($token));
    }
}
