<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Karyawan;
use App\Payslip;
use App\Designation;
use App\Branch;
use App\Allowance;
use App\SaturationDeduction;
use App\Department;
use App\Front\Employees;
use Auth;
use App\User;
use DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Http\Controllers\karyawan\AccountController;

class GajiController extends Controller
{
    protected $accountContrller;
    public function __construct(AccountController $accountContrller)
    {
        $this->accountContrller = $accountContrller;
    }

    public function payrollinfo($id){
        $karyawan = Karyawan::find($id);
        $initial = $this->accountContrller->getinitialname(Auth::guard("emp")->user()->name);
        return view('karyawan.account.payroll.index',compact('karyawan','initial'));
    }


    public function payslip($id){
        $karyawan = Karyawan::find($id);
        $initial = $this->accountContrller->getinitialname(Auth::guard("emp")->user()->name);
        return view('karyawan.account.payroll.payslip',compact('karyawan','initial'));
    }

    public function payslipAjax(request $request){
        $salary_month = $request->input('salary_month');
        $column = array('salary_month','payroll_cut_off','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $temp  = Payslip::join('employees','pay_slips.employee_id','=','employees.id')
                ->join('payslip_types','employees.salary_type','=','payslip_types.id')
                ->select('pay_slips.id','pay_slips.salary_month',"pay_slips.id as payroll_cut_off",'pay_slips.id as actions')
                ->where('pay_slips.employee_id',Auth::guard('emp')->user()->id)
                ->orderBy('pay_slips.salary_month','DESC');
        $total = $temp->count();
        $totalFiltered = $total;
    
        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(pay_slips.salary_month) LIKE '%".$search."%' OR LOWER(payslip_types.name) LIKE '%".$search."%' OR LOWER(pay_slips.basic_salary) LIKE '%".$search."%' OR LOWER(pay_slips.net_payble) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                $paid ='<a href="javascript:;" data-attr="'.route('emp.payroll.payslip.show.password',['id' => $row->id]).'"  class="btn btn-secondary btn-sm btn-show-form-password" title="View Payslip">
                            View payslip
                        </a>';
                $obj['salary_month']        = date('F',strtotime($row->salary_month));
                $obj['payroll_cut_off']     = "26 ".date("M",strtotime("-1 month",strtotime($row->salary_month)))." - "."25 ".date("M",strtotime($row->salary_month))." ".date("Y",strtotime($row->salary_month));
                $obj['actions']             = $paid;
                $data[] = $obj;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($total),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function showFormPassword($id){
        $payslip = Payslip::find($id);
        return view('karyawan.account.payroll.show-form-password',compact('payslip'));
    }

    public function storepasswordpayroll(request $request, $id){
        $validator = Validator::make($request->all(),[
            'password'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $user = Employees::find(Auth::guard("emp")->user()->id);
            $password = Hash::check($request->password, $user->password);
            if($password == true){
                return redirect()->route("emp.payroll.payslip.detail",$id)->with(['success'=>'Success Access Payslip !']);
            }else{
                return redirect()->back()->with(['danger'=>'Your Entered Password Is Wrong !']);
            }
        }
    }

    public function payslipdetail($id){
        $payslip = Payslip::find($id);
        $initial = $this->accountContrller->getinitialname(Auth::guard("emp")->user()->name);
        return view('karyawan.account.payroll.detail',compact('payslip','initial'));
    }

    public function downloadpayslippdf($id){
        $payslip = DB::table('pay_slips')->where('id',$id)->latest()->first();
        $employee = Karyawan::find($payslip->employee_id);
        $desgination = Designation::find($employee->designation_id);
        $signature = User::find($payslip->created_by);
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => storage_path().'/app/public/pdf',
            'format' => 'A4-P',
            'margin_left'=>10,
            'margin_right'=>10,
            'margin_top'=>10,
            'margin_bottom'=>15,
            'margin_header'=>10,
        ]);
        $mpdf->SetTitle($employee->name.' | '.date('F Y',strtotime($payslip->salary_month)));
        $mpdf->WriteHTML(view('karyawan.account.payroll.print-payslip',compact('payslip','employee','desgination','signature')));
        $mpdf->Output();
    }

}
