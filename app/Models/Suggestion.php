<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;
    protected $table='suggestion';
    protected $fillable=[
        'name',
        'user_id',
        'ksn',
        'reference_code',
        'device',
        'country',
        'images',
        'problem_statement',
        'situation_suggestion',
        'desired_outcome',
        'target_agency',
        'location',
        'status',
        'admin',
        'phone_number',
    ];
}
