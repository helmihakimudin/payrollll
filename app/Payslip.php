<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payslip extends Model
{
    protected $table = "pay_slips";

    protected $fillable = ['employee_id','net_payble','salary_month','status','is_bpjs_active','allowance','deduction'];

    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
