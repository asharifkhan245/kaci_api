<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{


    use HasFactory;

    protected $table = 'notification';
    protected $fillable = [
        'user_id',
        'title',
        'status',
        'item_id',
        'type'
    ];


}
