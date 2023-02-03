<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeThr extends Model
{
    protected $fillable = [
        'employee_id',
        'total_months',
        'amount_thr',
        'is_run'
    ];

    public function thr(){
        return $this->belongsTo(Employee::class);
    }
}
