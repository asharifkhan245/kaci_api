<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_Account extends Model
{
    use HasFactory;


    protected $table = "agency_sub_accounts";
    protected $fillable = [
    'agency_id', 
    'name',
    'email',
    'password', 
    'phone_number',
    'status',
    'privileges',
    'profile_image', 
    'country',
    'ambulance_service_id',
    'location'
    ];
}
