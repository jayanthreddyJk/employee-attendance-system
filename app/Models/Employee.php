<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Employee extends Authenticatable
{
    use HasFactory;
    protected $table = 'employees';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];
    protected $primaryKey = 'emp_id';
}
