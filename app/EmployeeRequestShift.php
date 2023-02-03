<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeRequestShift extends Model
{
    protected $table = "employee_request_shift";
    protected $fillable = ['employee_id','effective_date','new_shift','notes'];

    public function shift()
    {
        return $this->belongsTo(Shift::class,'new_shift');
    }

    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
