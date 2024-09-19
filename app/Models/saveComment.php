<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saveComment extends Model
{

    protected $table = "save_comments";

    protected $fillable = [
        'user_id',
        'comment_id',
        'status'
    ];
    use HasFactory;
}
