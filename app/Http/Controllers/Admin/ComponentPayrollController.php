<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Karyawan;
use Illuminate\Support\Facades\Auth;

class ComponentPayrollController extends Controller
{
    public function index(){
        return view('admin.payroll.component.index');
    }

    public function payroll(request $request){
        $column = array('full_name');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $temp  = Karyawan::join('pay_slips','employees.id','=','pay_slips.employee_id')
                ->select('employees.id','employees.full_name','employees.email','employees.salary_type','pay_slips.basic_salary','pay_slips.net_payble','employees.id as actions');
        // dd($temp);
        $total = $temp->count();
        // dd($total);
        $totalFiltered = $total;
    
        if (empty($request->input('search.value'))) {
            
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
           
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(employees.full_name) LIKE '%".$search."%' OR LOWER(employees.email) LIKE '%".$search."%'  OR LOWER(pay_slips.basic_salary) LIKE '%".$search."%' OR LOWER(pay_slips.net_payble) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)    
              ->limit($limit)
              ->get();
            $boot->count();
        }
        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                $edit  ="-";
                $hapus = "-";
                if(Auth::user()->can('Edit Gaji')){
                            $edit='<a href="'.route('gaji.edit',['id' => $row->id]).'"  class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                                        <i class="la la-eye"></i>
                                    </a>';
                }
                if(Auth::user()->can('Hapus Gaji')){
                  
                }
                $obj['name']            = $row->full_name;
                $obj['email']           = $row->email;
                $obj['salary_type']     = $row->salary_type;
                $obj['salary']          = "Rp.".number_format($row->basic_salary,2,',','.');
                $obj['net_salary']      = "Rp.".number_format($row->net_payble,2,',','.');
                $obj['actions']         = $edit;   
                $data[] = $obj;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTottal" => intval($total),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
}
