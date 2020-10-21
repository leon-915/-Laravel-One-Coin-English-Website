<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    protected $table = "location";

    protected $fillable = [
        'title','title_jp','location_type','status','seats_available',
        'phone_no','address','city','state','country','zipcode'
    ];

    public function teacherLocations() {
	    return $this -> belongsTo('App\Models\TeacherLocations');
	}
}
