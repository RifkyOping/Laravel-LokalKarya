<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'name',
        'email',
        'rating',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'rating'  => 'integer',
    ];
}
