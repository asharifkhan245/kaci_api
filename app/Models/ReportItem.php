<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportItem extends Model
{


    protected $table = 'repoted_items';
    protected $fillable = [
        'type',
        'item_id',
        'user_id',
        'status',
        'report_type_id',
        'description',
        'country'
    ];
    use HasFactory;
}
