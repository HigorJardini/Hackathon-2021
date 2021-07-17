<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DenunciationsType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active'
    ];

    public $timestamps = true;

    protected $table = 'historical_status';
}
