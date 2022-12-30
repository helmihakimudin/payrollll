<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestAttendance extends Model
{
    protected $touches = ["approval"];
    protected $guarded = [];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_request_attendance')
            ->withTimestamps();
    }

    public function approval()
    {
        return $this->belongsToMany(Approval::class, 'approval_transaction','transaction_id','approval_id')
        ->withPivot('approver_id','step','approved','status','created_at',
        'updated_at')
        ->withTimestamps();
    }
}
