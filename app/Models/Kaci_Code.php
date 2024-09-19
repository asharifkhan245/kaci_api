<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kaci_Code extends Model
{
    use HasFactory;
    protected $table='kaci_code';
    protected $fillable=[
        'amount',
        'request_day',
        'request_week',
        'request_monthly',
        'code',
        'status',
        'expiry_date',
        'user_count',
        'type',
        'consultation_requests',
        'ambulance_requests',
        'travelsafe_requests',
        'emergnecy_requests'
    ];
}
