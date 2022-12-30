<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    protected $table = "allowances";
    protected $fillable = [
        'id',
        'employee_id',
        'allowance_option',
        'month',
        'amount',
        'created_by',
    ];
    public function karyawan()
    {
        return $this->hasOne('App\Karyawan', 'id', 'employee_id')->first();
    }

    public function allowance_option()
    {
        return $this->hasOne('App\AllowanceOption', 'id', 'allowance_option')->first();
    }
}
