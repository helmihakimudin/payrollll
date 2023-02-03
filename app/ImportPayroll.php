<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportPayroll extends Model
{
    protected $fillable = ['employee_id','payroll_component_id','month','total_attendance','total_working_permonth'];

    public function getDataEmployeeByEmployeeId(){
        return $this->belongsTo('App\Employee','employee_id','employee_id');
    }
}
