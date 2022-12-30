<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    protected $table = "job_position";

    public function employee()
    {
        return $this->hasOne(Employee::class, 'job_position_id');
    }
}
