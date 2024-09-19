<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_Email extends Model
{
    use HasFactory;
    protected $table='admin_email';
    protected $fillable=[
'name',
'email',
    ];
}
