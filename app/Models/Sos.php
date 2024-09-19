<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sos extends Model
{
    use HasFactory;
    protected $table ='sos';
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
        'location',
        'address',
        'comments',
        'target_agency',
        'map',
        'coordinate',
        'images',
        'email',
    ];
}
