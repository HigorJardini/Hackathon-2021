<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPhones extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_id',
        'order',
        'active'
    ];

    public $timestamps = true;

    use SoftDeletes;

    protected $table = 'user_phones';
}
