<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class General_Countries extends Model
{
    use HasFactory;
    protected $table='general_countries';
    protected $fillable=[
        'country_name',
        'country_code',
        'flag_code',
        'featured',
    'status'
    ];
}
