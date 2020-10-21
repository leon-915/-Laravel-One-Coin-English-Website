<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingTypes extends Model
{
    protected $table = 'teacher_rating_types';

    protected $fillable = ['title','description','desc_star1','desc_star2',
                            'desc_star3','desc_star4','desc_star5','status'];
}
