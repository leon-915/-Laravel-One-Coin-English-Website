<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategories extends Model
{
    protected $table = 'services_categories';

    protected $fillable = ['service_id','category_id','is_deleted'];
}
