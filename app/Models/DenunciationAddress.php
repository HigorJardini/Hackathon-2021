<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DenunciationAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'denunciation_id',
        'address_id'
    ];

    public $timestamps = true;
    protected $table = 'denunciation_address';
}
