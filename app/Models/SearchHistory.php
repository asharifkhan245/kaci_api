<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{

    protected $table = 'search_history';
    protected $fillable  = [

        'user_id',
        'search_term'
    ];
    use HasFactory;
}
