<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportType extends Model
{
    protected $table = 'report_types';

    protected $fillable = [
        'name'
    ];
    use HasFactory;
}
