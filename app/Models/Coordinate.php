<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinate extends Model
{
    use HasFactory;
    protected $table='coordinate';
    protected $fillable=[
        'coordinate',
        'user_id',
        'travel_id',
    ];
}
