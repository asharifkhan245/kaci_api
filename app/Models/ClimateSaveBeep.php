<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClimateSaveBeep extends Model
{
    protected $table = 'climate_save_beeps';
    protected $fillable  = [
        'user_id',
        'climate_id',
        'status'
    ];
    use HasFactory;
}
