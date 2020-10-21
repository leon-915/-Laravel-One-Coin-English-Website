<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceLocations extends Model
{
    protected $table = 'services_locations';

    protected $fillable = ['service_id','location_id'];
}
