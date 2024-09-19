<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module_Request extends Model
{
    use HasFactory;
    protected $table='module_request';
    protected $fillable=[
        'travel',
        'ambulance',
        'emergency',
        'consultation'
    ];
}
