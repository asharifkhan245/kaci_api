<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group_Chat extends Model
{
    use HasFactory;
    protected $table="group_chat";
    protected $fillable=[
        "module","module_id","reference_code","message","target_agency"
    ];

}
