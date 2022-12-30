<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peran extends Model
{
    protected $table = "roles";


    public  function users(){
        return $this->hasMany(User::class,'role_id');
    }
}
