<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    protected $table = "overtimes";

    protected $guarded = [];

    public function approval()
    {
        return $this->belongsToMany(Approval::class, 'approval_transaction','transaction_id','approval_id')
        ->withPivot('approver_id','step','approved','status','created_at',
        'updated_at')
        ->withTimestamps();
    }

}
