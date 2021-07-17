<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogsSystem extends Model
{
    
    protected $fillable = [
        'user_id', 
        'origin',
        'http_code',
        'content_error'
    ];

    public $timestamps = true;

    protected $table = 'logs_system';
}
