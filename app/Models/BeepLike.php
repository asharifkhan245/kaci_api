<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeepLike extends Model
{
    use HasFactory;
    protected $table="beep_likes";
    protected $fillable=[
        'user_id',
        'beep_id',
        'status',
        'like_status'
    ];
}
