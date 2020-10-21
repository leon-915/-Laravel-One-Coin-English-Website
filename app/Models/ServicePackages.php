<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePackages extends Model
{
    protected $table = 'services_packages';

    protected $fillable = ['service_id','package_id','is_deleted'];

    public function service() {
        return $this->belongsTo('App\Models\Services', 'service_id','id');
    }
}
