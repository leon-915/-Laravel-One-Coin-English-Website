<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class SearchAnalytics extends Model
{
    protected $table='search_analytics';

    public $timestamps = "true";

    protected $fillable = [
        'user_id', 'keyword', 'searched_on', 'search_count', 'created_at', 'updated_at'];
}
