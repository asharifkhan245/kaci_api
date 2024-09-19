<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_Notification extends Model
{
    use HasFactory;
    protected $table='admin_notification';
    protected $fillable=['user_id','u_id','name','notification','status','sub_admin_id'];

}
