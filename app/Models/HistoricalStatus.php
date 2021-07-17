<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoricalStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'denunciation_id',
        'status_id'
    ];

    public $timestamps = true;
    
    use SoftDeletes;

    protected $table = 'historical_status';
}
