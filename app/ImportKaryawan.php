<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportKaryawan extends Model
{
    protected $table ="employees";

    protected $fillable = [
        'id',
        'name',
        'salary',
        'net_salary',
        'created_by',
    ];
}
