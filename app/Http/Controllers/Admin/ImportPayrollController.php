<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ImportPayroll;

class ImportPayrollController extends Controller
{
    public function index(){
        return view('admin.payroll.import.index');
    }
}
