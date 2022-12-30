<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{

    protected $touches = ["requestAttendance"];
    protected $guarded = [];

    public function requestAttendance()
    {
        return $this->belongsToMany(RequestAttendance::class, 'approval_transaction', 'transaction_id','approval_id')
        ->withPivot('step','approved','status','created_at',
        'updated_at')
        ->withTimestamps();
    }

    public function employee()
    {
        return $this->belongsToMany(Employee::class, 'approval_transaction',null,'approver_id');
    }
}
