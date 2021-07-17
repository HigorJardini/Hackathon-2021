<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'denunciations_type_id',
        'name',
        'active',
        'order'
    ];

    public $timestamps = true;

    protected $table = 'historical_status';
}
