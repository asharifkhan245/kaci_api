<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareClimateBeep extends Model
{

    protected $table  = 'share_climate_beeps';
    protected $fillable  = [
        'user_id',
        'climate_id',
        'status'
    ];
    
    use HasFactory;
}
