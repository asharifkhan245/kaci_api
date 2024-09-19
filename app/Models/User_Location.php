<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Location extends Model
{
    use HasFactory;
    protected $table='user_location';
    protected $fillable=['user_id','coordinate'];
}
