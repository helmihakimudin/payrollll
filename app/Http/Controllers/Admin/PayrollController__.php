<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use Auth; 

class PayrollController extends Controller
{
    public function index(){
        return view('admin.payroll.index');
    }
}
