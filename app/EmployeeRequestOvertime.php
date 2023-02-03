<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeRequestOvertime extends Model
{
    protected $table = 'employee_request_overtime';

    public function statusRequestOvertime(){
        return $this->belongsTo(StatusRequestOvertime::class, 'overtime_request_id');
    }
}
