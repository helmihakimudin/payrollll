<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = "branches";
    protected $fillable = [
        'id',
        'name',
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}
