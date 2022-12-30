<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $guarded = [];

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function calendars()
    {
        return $this->belongsToMany(Calendar::class, 'calendar_shift')->withPivot(['is_day_off'])->withTimestamps();
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'schedule_id');
    }

    public function calendarWithShift()
    {
        return $this->calendars()->where;
    }
}
