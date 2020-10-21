<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnePageLevelsPoints extends Model
{
    protected $table = 'one_page_levels_points';

    protected $fillable = ['level_id','rating_point','description_en','description_ja','status'];
}
