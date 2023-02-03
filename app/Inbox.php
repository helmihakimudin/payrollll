<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $table = "inbox";

    public function employeeSender(){
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function employeeRecipient(){
        return $this->belongsTo(Employee::class,'request_to');
    }
}
