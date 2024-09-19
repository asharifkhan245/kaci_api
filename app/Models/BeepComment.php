<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeepComment extends Model
{
    use HasFactory;
    protected $table="beep_comments";
    protected $fillable=[
        'user_id',
        'beep_id',
        'comment',
        'status',
        'like'
    ];
}
