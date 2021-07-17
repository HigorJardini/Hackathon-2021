<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denunciations extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_id',
        'denunciations_type_id',
        'code',
        'description',
        'active'
    ];

    public $timestamps = true;
    protected $table = 'denunciations';
}
