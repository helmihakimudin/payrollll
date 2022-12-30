<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name', 'latitude', 'longitude'
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_location')
            ->withTimestamps();
    }
}
