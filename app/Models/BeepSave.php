<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeepSave extends Model
{
    use HasFactory;
    protected $table="beep_saves";
    protected $fillable=[
        'user_id',
        'beep_id',
        'status',
    ];
}
