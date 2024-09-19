<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    use HasFactory;


    protected $table  = 'comments_reply';

    protected $fillable = [
        'comment_id',
        'user_id',
        'comment',
        'beep_id'
    ];
}
