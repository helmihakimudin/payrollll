<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayrollEmployeeComponent extends Model
{
    protected $table = "payroll_employee_component";

    protected $fillable = ['employee_id','component','is_created','is_run'];
}
