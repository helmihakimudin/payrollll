<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleAssignment extends Model
{
    protected $table = 'schedule_assignments';

    protected $fillable = ['name','working_hour_start','working_hour_end'];

    public function shift(){
        return $this->belongsTo(Shift::class,'shift_id');
    }
}
