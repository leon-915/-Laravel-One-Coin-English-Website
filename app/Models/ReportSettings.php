<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportSettings extends Model
{
    protected $table = 'report_settings';

    protected $fillable = ['ultimate','ideal','target','minimum'];
}

