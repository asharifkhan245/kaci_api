<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClimateBeeplike extends Model
{

    protected $table  = 'climate_beeplikes';

    protected $fillable  = [
        'user_id',
        'climate_id',
        'status'
    ];
    use HasFactory;
}
