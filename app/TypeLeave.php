<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeLeave extends Model
{
    protected $guarded = [];

    public function paidLeave()
    {
        return $this->hasOne(PaidLeave::class);
    }
}
