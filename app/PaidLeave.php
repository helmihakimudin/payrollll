<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaidLeave extends Model
{
    protected $table = "paid_leave";
    protected $guarded = [];


    protected $hidden = [
        'type_leave_id','employee_id'
    ];

    public function typeLeave(){
        return $this->belongsTo(TypeLeave::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function type_leave(){
        return $this->belongsTo(TypeLeave::class, 'type_leave_id');

    }
}
