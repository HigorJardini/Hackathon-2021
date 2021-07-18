<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'neighborhood_id',
        'content'
    ];

    public $timestamps = true;
    protected $table = 'address';
}
