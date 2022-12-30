<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [];

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
    
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'attendance_employee')
            ->withPivot('id', 'clock_in', 'clock_out', 'attendance_type', 'latitude', 'longitude', 'note', 'image')
            ->withTimestamps();
    }

    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
}
