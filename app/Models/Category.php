<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {


    protected $table = "categories";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'parent_id', 'path','status'
    ];

    public $timestamps=true;

    public function parent(){
        return $this->belongsTo('App\Models\Category','parent_id','id');
    }

    public function children(){
        return $this->hasMany('App\Models\Category','parent_id');
    }

    public function edcatchildren(){
        return $this->hasMany('App\Models\Category','parent_id');
    }

    public function sizes(){
        return $this->hasMany('App\Models\Size');
    }
}
