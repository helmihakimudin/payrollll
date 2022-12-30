<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
     protected $table = "organization";

    public function employee() {
        return $this->hasOne(Employee::class);
    }
}
