<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $table = 'testimonial';

    protected $fillable = [
                            'title',
							'title_ja',
                            'description_en',
                            'description_ja',
                            'excerpt',
							'excerpt_ja',
                            'position',
							'position_ja',
                            'status'
                          ];
}
