<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Joblevel extends Model
{
    protected $table = "job_level";

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}



