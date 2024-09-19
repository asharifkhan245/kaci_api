<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependant extends Model
{
    use HasFactory;
    protected $table='dependant';
    protected $fillable=[
        'user_id',
        'name',
        'email',
        'phone_number',
        'relation_type',
        'country',
    ];
}
