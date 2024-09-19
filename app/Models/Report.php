<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table='report';
    protected $fillable=[
        'user_id',
        'ksn',
        'reference_code',
        'name',
        'device',
        'country',
        'phone_number',
        'location',
        'address',
        'date',
        'time',
        'target_agency',
        'subject',
        'details',
        'response',
        'anonymous',
        'admin',
        'status',
        'images',
        'map',
        'map_link'
    ];
}
