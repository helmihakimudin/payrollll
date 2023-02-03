<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Employee;
use App\PayrollEmployeeComponent;
use Carbon\Carbon;

class SignaturePadController extends Controller
{

    public function index(Request $request)
    {

        $id = Auth::id();
        $employee = Employee::with(['organization','branch'])->where('employees.user_id','=',$id)->first();
        $componentSalary = PayrollEmployeeComponent::where('employee_id', $employee->id)->pluck('component')->first();
        $arrComponent = json_decode($componentSalary);
        if(is_array($arrComponent)){
            $takeHomePay = $arrComponent[0]->amount;
            setlocale(LC_ALL, 'IND');
            $employeeJoinDate = Carbon::parse($employee->join_date)->formatLocalized('%d %B %Y');
            $threeMonthsProbation = Carbon::parse($employee->join_date)->addMonths(3)->formatLocalized('%d %B %Y');
            return view('admin/signcontract/index',compact('employee','takeHomePay','employeeJoinDate','threeMonthsProbation'));
        }else{
            return back();
        }
    }

    public function signature(){
        return view('admin/signcontract/signature');
    }

    public function upload(Request $request)
    {
        $folderPath = storage_path('app/public/upload/');

        $image_parts = explode(";base64,", $request->signed);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        //get employee id
        $id = Auth::id();
        $employee = Employee::with(['organization','branch'])->where('employees.user_id','=',$id)->first();

        $file = $folderPath . $employee->employee_id . '.'.$image_type;
        file_put_contents($file, $image_base64);
        return back()->with('success', 'success Full upload signature');
    }
}
