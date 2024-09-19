<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency_Notification extends Model
{
    protected $table='agency_notifications';
    
    
    protected $fillable=['user_id','u_id','name','notification','status','agency_id', 'type'];
    use HasFactory;
}
