<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportPayroll extends Model
{
    protected $fillable = ['employee_id','month','total_attendance','total_working_permonth'];

    public function getDataEmployeeByEmployeeId(){
        return $this->belongsTo('App\Employee','employee_id','employee_id');
    }
}
