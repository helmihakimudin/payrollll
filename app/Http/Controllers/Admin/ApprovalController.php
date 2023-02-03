<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee;
use App\StatusRequestAttendance;
use App\StatusRequestOvertime;
use Carbon;

class ApprovalController extends Controller
{
    public function index()
    {
        //Request Attendance
        $employeeRequestAttendance = Employee::with('employeeRequestAttendance')->get();
        $statusRequestAttendance = StatusRequestAttendance::with('listEmployeeRequestAttendance')->orderBy('id','desc')->get();
        
        //Request Shift
        $employeeRequestShift = Employee::with('employeeRequestShift')->get();

        //Request Overtime
        $employeeRequestOvertime = Employee::with('employeeRequestOvertime')->where('id',504)->get();
        $statusRequestOvertime = StatusRequestOvertime::with('listEmployeeRequestOvertime')->orderBy('id','desc')->get();
      
        return view('admin.approval.index',compact('employeeRequestAttendance','statusRequestAttendance','employeeRequestShift','employeeRequestOvertime','statusRequestOvertime'));
    }
}
