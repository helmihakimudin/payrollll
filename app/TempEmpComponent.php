<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempEmpComponent extends Model
{
    protected $table = "temp_emp_component";

    protected $fillable = ['id','employee_id','component_id','amount'];
}
