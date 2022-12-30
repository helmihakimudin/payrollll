<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeoff extends Model
{
    protected $table = 'timeoffs';

    public function employee()
    {
        return $this->belongsToMany(Employee::class);
    }
}
