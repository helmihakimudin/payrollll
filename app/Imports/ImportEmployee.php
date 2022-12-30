<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\employee;
use Illuminate\Support\Facades\Hash;

use Auth;

class ImportEmployee implements ToModel,WithHeadingRow
{
    public function model(array $row)
    {

       return new employee([
            'head_employee_id' => Auth::user()->id,
            'name' => $row['nama'] ?? 0,
            'role' =>'employee',
            'email'=>$row['email'] ?? 0,
            'password'=> hash::make($row['password'])?? 0,
        ]);      
    }
}
