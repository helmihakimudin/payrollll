<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee;
use App\Organization;
use App\JobPosition;
use Auth;
use DB;

class EmployeeController extends Controller
{
    public function index(){

        $all = Employee::where('organization_id', \Auth::guard('emp')->user()->organization_id )->get();
        return view("karyawan.employees.index", compact('all'));

    }

}
