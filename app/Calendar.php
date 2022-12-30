<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{

    protected $guarded = [];

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'calendar_shift')->withPivot(['is_day_off'])->withTimestamps();;
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}
