<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambulance_subaccount extends Model
{
    protected $table  = 'ambulance_subaccounts';
    protected $fillable  = [
        'ambulance_id',
        'country',
        'name',
        'email',
        'password',
        'phone_number',
        'profile_image',
        'status',
        'previlages'

    ];
    
    use HasFactory;
}
