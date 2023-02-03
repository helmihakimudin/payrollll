<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class AttendanceEmployee extends Model
{
    protected $table ="attendance_employee";

    // protected function serializeDate(DateTimeInterface $date){
    //     return $date->format('Y-m-d h:i:s');
    // }
}
