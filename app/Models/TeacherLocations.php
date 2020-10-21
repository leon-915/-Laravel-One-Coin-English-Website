<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherLocations extends Model
{
    protected $table='teacher_locations';

    public $timestamps = "true";

    protected $fillable = [
        'user_id',
        'location_id',
        'is_deleted'
    ];

    public function location(){
        return $this->belongsTo('App\Models\Locations','location_id','id');
    }

}
