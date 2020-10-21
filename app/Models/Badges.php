<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badges extends Model
{
    protected $table = 'badges';

    protected $fillable = ['title','image','description','status'];
}
