<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedBeep extends Model
{

    protected $table  = "shared_beeps";

    protected $fillable = [
        'beep_id',
        'user_id',
        'text',
        'status'
    ];
    use HasFactory;
}
