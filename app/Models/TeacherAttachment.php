<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAttachment extends Model
{
    protected $table='teacher_attachments';

    public $timestamps = "true";

    protected $fillable = [
        'user_id',
        'attachment_url',
        'type',
    ];
}
