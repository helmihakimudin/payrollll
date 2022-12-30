<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaturationDeduction extends Model
{
    protected $table = "saturation_deductions";
    protected $fillable = [
        'id',
        'employee_id',
        'deduction_option',
        'month',
        'amount',
        'created_by',
    ];
}
