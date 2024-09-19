<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Climate extends Model
{
    use HasFactory;
    protected $table='climate';
    protected $fillable=[
        'user_id',
        'question',
        'name',
        'resident_country',

        'total',


    ];
}
