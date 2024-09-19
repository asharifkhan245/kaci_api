<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambulance extends Model
{
    use HasFactory;
    protected $table='ambulance';
    protected $fillable=[
        'ksn',
        'user_id',
        'reference_code',
        'name',
        'device',
        'phone_number',
        'country',
        'ambulance_service',
        'people_involved',
        'incidence_nature',
        'previous_hospital',
        'medication',
        'status',
        'response',
        'admin',
        'images',
        'location',
        'address',
        'map',
    ];
}
