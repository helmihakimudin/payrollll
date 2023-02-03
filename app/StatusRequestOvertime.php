<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusRequestOvertime extends Model
{
    protected $table = "status_request_overtime";
    
    public function listEmployeeRequestOvertime(){
        return $this->belongsTo(EmployeeRequestOvertime::class,'overtime_request_id');
    }
}
