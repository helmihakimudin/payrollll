<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusRequestAttendance extends Model
{
    protected $table = "status_request_attendance";

    public function listEmployeeRequestAttendance(){
        return $this->belongsTo(EmployeeRequestAttendance::class,'employee_request_attendance_id');
    }
}
