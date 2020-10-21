<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = ['title_en', 'title_ja', 'status'];

    
}
