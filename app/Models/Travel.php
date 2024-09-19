<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;
    protected $table ='travel';
    protected $fillable=[
        'ksn',
        'user_id',
        'reference_code',
        'name',
        'phone_number',
        'email',
        'device',
        'country',
        'response',
        'status',
        'admin',
        'destination',
        'boarding',
        'trip_duration',
        'additional_info',
        'images',
        'vehicle_type',
        'vehicle_detail',
        'coordinate',
        'map',
        'trip_status',
        'notify_status',
        'email_status',
    ];
}
