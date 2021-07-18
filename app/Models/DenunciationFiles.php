<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DenunciationFiles extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_id',
        'denunciation_id',
    ];

    public $timestamps = true;
    protected $table = 'denunciation_files';
}
