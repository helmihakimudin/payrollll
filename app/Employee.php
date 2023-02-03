<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasApiTokens;
    protected $guarded = [];

    // protected $hidden = [
    //     'password','schedule_id'
    // ];

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'schedule_id');
    }

    public function shift_with_calendar_now()
    {
        return $this->shift()->calendarWithShift();
    }

    public function attendances()
    {
        return $this->belongsToMany(Attendance::class, 'attendance_employee')
            ->withPivot('id', 'clock_in', 'clock_out', 'attendance_type', 'latitude', 'longitude', 'note', 'image')
            ->withTimestamps();
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'employee_location');
    }

    public function requestAttendances()
    {
        return $this->belongsToMany(RequestAttendance::class, 'employee_request_attendance')
            ->withPivot('id', 'employee_id', 'request_attendance_id')
            ->withTimestamps();
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id','id');
    }

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class, 'job_position_id', 'id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function jobLevel()
    {
        return $this->belongsTo(Joblevel::class, 'job_level_id', 'id');
    }

    public function approval()
    {
        return $this->belongsToMany(Approval::class, 'approval_transaction', 'transaction_id','approver_id')
        ->withPivot('step','approved','status','created_at','updated_at')
        ->withTimestamps();
    }

    public function thr(){
        return $this->hasOne(EmployeeThr::class);
    }

    public function employeeApprovalLine(){
        return $this->belongsTo(Employee::class,'approval_line_id');
    }
    
    public function employeeRequestAttendance(){
        return $this->hasMany(EmployeeRequestAttendance::class,'employee_id');
    }

    public function employeeRequestShift(){
        return $this->hasMany(EmployeeRequestShift::class,'employee_id');
    }

    public function employeeRequestOvertime(){
        return $this->hasMany(EmployeeRequestOvertime::class,'employee_id');
    }
}
