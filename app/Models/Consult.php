<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consult extends Model
{
    use HasFactory;
protected $table='consult';
    protected $fillable=[
        'location','user_id','ksn','reference_code','images','target_agency','subject',
    'description','anonymous','status','response','admin','device','phone_number', 'country'
    ];
}
