<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnePageLevels extends Model
{
    protected $table = 'one_page_levels';

    protected $fillable = ['name','description_en','description_ja','status'];

    public function points() {
        return $this->hasMany('App\Models\OnePageLevelsPoints', 'level_id','id')->where('status',1)->orderBy('id', 'ASC');
    }

    public function ca() {
        return $this->hasMany('App\Models\OnePageLevelsPoints', 'level_id','id')
        ->where('status',1)->where('rating_point','CA')
        ->orderBy('id', 'ASC');
    }

    public function fp() {
        return $this->hasMany('App\Models\OnePageLevelsPoints', 'level_id','id')
                    ->where('status',1)->where('rating_point','FP')
                    ->orderBy('id', 'ASC');
    }

    public function lc() {
        return $this->hasMany('App\Models\OnePageLevelsPoints', 'level_id','id')
                    ->where('status',1)->where('rating_point','LC')
                    ->orderBy('id', 'ASC');
    }

    public function v() {
        return $this->hasMany('App\Models\OnePageLevelsPoints', 'level_id','id')
                    ->where('status',1)->where('rating_point','V')
                    ->orderBy('id', 'ASC');
    }

    public function ga() {
        return $this->hasMany('App\Models\OnePageLevelsPoints', 'level_id','id')
                    ->where('status',1)->where('rating_point','GA')
                    ->orderBy('id', 'ASC');
    }
}
