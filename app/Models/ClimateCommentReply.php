<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClimateCommentReply extends Model
{

    protected $table  = 'climate_comment_replies';
    protected $fillable = [
        'user_id',
        'comment_id',
        'comment',
        'climate_id'
    ];
    use HasFactory;
}
