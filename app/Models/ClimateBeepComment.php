<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClimateBeepComment extends Model
{

    protected $table  = 'climate_beep_comments';
    protected $fillable  = [
        'user_id',
        'climate_id',
        'comment',
        'like'
    ];

    use HasFactory;
}
