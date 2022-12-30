<?php

namespace App\Front;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employees extends Authenticatable
{
    protected $table ="employees";
    protected $fillable = [
        'head_employee_id',
        'name',
        'role',
        'email',
        'password',        
    ];
}
