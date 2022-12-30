<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TempEmpComponent;
use App\Employee;

class PayrollComponent extends Model
{
    protected $table = "payroll_component";


    // public static function getAllowance($id, $transaksi_id){
    //     $employee  = Employee::find($id);
    //     $tempEmpComponent = TempEmpComponent::join('component','temp_emp_component.component_id','=','component.id')
    //                         ->join('employees','temp_emp_component.employee_id','=','employees.id')
    //                         ->select('component.name','temp_emp_component.amount','employees.full_name')
    //                         ->where('payroll_component_id',$transaksi_id)
    //                         ->where('temp_emp_component.employee_id',$id)
    //                         ->where('component.type','Allowance')
    //                         ->get();
    //     $total_allowance = 0;
    //     foreach($tempEmpComponent as $row){
    //         $total_allowance += $row->amount;
    //     }
    
    //     $total = $total_allowance + $employee->basic_salary;
    //     return $total;
    // }

    // public static function getDeductions($id, $transaksi_id){
    //     $tempEmpComponent = TempEmpComponent::join('component','temp_emp_component.component_id','=','component.id')
    //                         ->join('employees','temp_emp_component.employee_id','=','employees.id')
    //                         ->select('component.name','temp_emp_component.amount','employees.full_name')
    //                         ->where('payroll_component_id',$transaksi_id)
    //                         ->where('temp_emp_component.employee_id',$id)
    //                         ->where('component.type','Deduction')
    //                         ->get();
    //     $totaldeduction = 0;
    //     foreach($tempEmpComponent as $row){
    //         $totaldeduction += $row->amount;
    //     }
        
    //     $employee  = Employee::find($id);
    //     $totaltotalbpjs = 0;
    //     $totaltotalbpjs = $employee->bpjs_kesehatan_cost + $employee->bpjs_jht_cost + $employee->jaminan_pensiun_cost;
    //     $total = $totaldeduction + $totaltotalbpjs;
    //     return $total;
    // }
    
    // public static function allowanceList($id, $transaksi_id){
    //     $tempEmpComponent = TempEmpComponent::join('component','temp_emp_component.component_id','=','component.id')
    //                     ->join('employees','temp_emp_component.employee_id','=','employees.id')
    //                     ->select('temp_emp_component.id','component.name','temp_emp_component.amount')
    //                     ->where('payroll_component_id',$transaksi_id)
    //                     ->where('temp_emp_component.employee_id',$id)
    //                     ->where('component.type','Allowance')
    //                     ->get();

    //     $listallowance = json_encode($tempEmpComponent);

    //     return $listallowance;
    // }

    // public static function deductionList($id, $transaksi_id){
    //     $tempEmpComponent = TempEmpComponent::join('component','temp_emp_component.component_id','=','component.id')
    //                     ->join('employees','temp_emp_component.employee_id','=','employees.id')
    //                     ->select('temp_emp_component.id','component.name','temp_emp_component.amount')
    //                     ->where('payroll_component_id',$transaksi_id)
    //                     ->where('temp_emp_component.employee_id',$id)
    //                     ->where('component.type','Allowance')
    //                     ->get();

    //     $listdeductions = json_encode($tempEmpComponent);

    //     return $listdeductions;
    // }
   
}