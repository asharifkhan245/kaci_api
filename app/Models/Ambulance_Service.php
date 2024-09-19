<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambulance_Service extends Model
{
    use HasFactory;
    protected $table='ambulance_service';
    protected $fillable=[
'logo',
'title',
'country',
'contact_number',
'featured',
'address',
'head_email1',
'head_email2',
'head_contact_number1',
'head_contact_number2',
'location',
    'status',
    ];
}
