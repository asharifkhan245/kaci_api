<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agencies extends Model
{
    use HasFactory;
    protected $table='agencies';
    protected $fillable=[
'logo',
'title',
'country',
'website',
'contact_number',
'featured',
'address',
'head_email1',
'head_email2',
'head_contact_number1',
'head_contact_number2',
'location',
    'modules',
    'status',
    ];
}
