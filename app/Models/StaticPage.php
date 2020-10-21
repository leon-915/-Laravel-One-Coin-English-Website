<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    protected $table='static_pages';

    public $timestamps = "true";

    protected $fillable = [
        'page_name','title','body','meta_description','meta_keyword'
    ];
}
