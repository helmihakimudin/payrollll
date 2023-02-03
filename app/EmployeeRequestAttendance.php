<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeRequestAttendance extends Model
{
    protected $table = 'employee_request_attendance';

    public function employee(){
        return $this->belongsTo(Employee::class, 'id');
    }

    public function statusRequestAttendance(){
        return $this->hasMany(StatusRequestAttendance::class, 'employee_request_attendance_id');
    }
}
