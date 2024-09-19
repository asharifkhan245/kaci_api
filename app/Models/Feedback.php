<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table='feedback';
    protected $fillable=[
'user_id',
'name',
'email',
'phone_number',
'country',
'device',
'reference_code',
'text',
'image',
'status',
'response',
'admin',
    ];
}
