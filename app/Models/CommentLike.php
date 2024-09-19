<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentlike extends Model
{

    protected $table = 'comment_likes';


    protected $fillable = [
        'user_id',
        'comment_id',
        'status'
    ];
    use HasFactory;
}
