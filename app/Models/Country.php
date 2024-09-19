<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table='country';
    protected $fillable=[
        'country',
        'country_name',
        'flag_code',
        'country_code',
        'local_number',
        'emergency_number',
        'gcare_email',
        'admin_email',
        'featured',
    'status',
    ];
}
