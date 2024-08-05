<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'emp_id',
        'date',
        'login_time',
        'logout_time',
        'total_login_hours',
        'break_time',
        'overtime',
    ];
}
