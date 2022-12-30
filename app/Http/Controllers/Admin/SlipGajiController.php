<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Karyawan;
use App\Payslip;
use App\Designation;
use App\User;
use App\Exports\ExportGaji;
use App\Exports\ExportToBca;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Events\SlipGajiEvent;
use App\Allowance;
use App\SaturationDeduction;
use Mail;
use PDF;
use App\Mail\EmployeeEmail;
use App\Announcement;

class SlipGajiController extends Controller
{
    public function index(){
        return view('admin.slipgaji.index');
    }

    public function payslipAjax(request $request){
        $salary_month = $request->input('salary_month');
        $column = array('employee','salary_type','basic_salary','net_payble','status','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $temp  = Payslip::join('employees','pay_slips.employee_id','=','employees.id')
                ->join('payslip_types','employees.salary_type','=','payslip_types.id')
                ->select('pay_slips.id','employees.name as employee','payslip_types.name as salary_type','pay_slips.basic_salary','pay_slips.net_payble','pay_slips.status','pay_slips.slipbyemail','pay_slips.id as actions')
                ->where('salary_month',$salary_month);
        $total = $temp->count();
        $totalFiltered = $total;
    
        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(employees.name) LIKE '%".$search."%' OR LOWER(payslip_types.name) LIKE '%".$search."%' OR LOWER(pay_slips.basic_salary) LIKE '%".$search."%' OR LOWER(pay_slips.net_payble) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                $status = "";
                if($row->status ==1){
                    $status = '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Paid</span>';
                }else{
                    $status = '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Unpaid</span>';
                }
                    $paid = "";
                if($row->status !=0){
                    $paid ='';
                }else{
                    $paid ='<a href="javascript:;" data-id='.$row->id.' onclick=PaidFunction(this);  class="btn btn-success btn-elevate btn-circle btn-icon " title="Paid">
                                <i class="fa fa-money-bill"></i>
                            </a>';
                }

                $slipbyemail = "";

                if($row->slipbyemail !=0){
                    $slipbyemail ='<a href="javascript:;" data-id='.$row->id.'   class="btn btn-success btn-elevate btn-circle btn-icon btn-send-back" title="Success Terkirim">
                                        <i class="flaticon-email"></i>
                                    </a>';
                    
                }else{
                    $slipbyemail = '<a href="javascript:;" data-id='.$row->id.' class="btn btn-primary btn-elevate btn-circle btn-icon btn-send-email" title="Kirm Slip Gaji Lewat Email">
                                        <i class="flaticon-email"></i>
                                    </a>';
                  
                }
            
      
                $obj['employee']        = '<a href="javascript:;" data-href='.route('slipgaji.detail.karyawan',$row->id).' class="btn-edit-slip" title="Paid">'.$row->employee.'</a>';
                $obj['salary_type']     = $row->salary_type;
                $obj['basic_salary']    = "Rp.".number_format($row->basic_salary,2,',','.');
                $obj['net_payble']      = "Rp.".number_format($row->net_payble,2,',','.');
                $obj['status']          = $status;
                $obj['actions']         = '<a href="'.route('slipgaji.pdf',['id' => $row->id]).'" target="_blank" class="btn btn-warning btn-elevate btn-circle btn-icon " title="Slip Gaji">
                                             <i class="flaticon-list"></i>
                                          </a>
                                          '."&nbsp;".$paid."&nbsp;".$slipbyemail;
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

    public function paid($id){
        $paid = Payslip::find($id);
        $paid->status = 1;
        $paid->save();
        return response()->json($paid);
    }

    public function paidall(request $request){
        $month = $request->input('salary_month');
        $paid = Payslip::where('salary_month',$month)->update([
            'status'=>1,
        ]);
        $paids = Payslip::where('salary_month',$month)->get();
        foreach($paids as $row){
            event(new SlipGajiEvent($name="slipgaji", $description= "Slip Gaji Bulan ".date('F Y',strtotime($month))." Sudah Keluar Silahkan Di Cek", $read_at = 2, $employee_id = $row->employee_id));
        }
        return response()->json($paid);
    }

    public function destroy(request $request){
        $month = $request->input('salary_month');
        $paid = Payslip::where('salary_month',$month)->delete();
        return redirect()->back()->with(['success'=>'Slip Gaji Berhasil dihapus']);    
    }

    public function store(request $request){
        $karyawan = Karyawan::where('salary','!=',null)->get();
        $monthyear = date('Y-m',strtotime($request->input('salary_month')));
        $validate    = PaySlip::where('salary_month', '=', $monthyear)->get()->toarray();
        if(empty($validate)){
            foreach($karyawan as $row){
                $payslip  = new Payslip;
                $payslip->employee_id           = $row->id;
                $payslip->salary_month          = $monthyear;
                $payslip->net_payble            = Karyawan::gajibersih($row->id);
                $payslip->basic_salary          = $row->salary;
                $payslip->status                = 0;
                $payslip->allowance             = Karyawan::tunjangan($row->id);
                $payslip->saturation_deduction  = Karyawan::pengurangan($row->id);
                $payslip->created_by            = Auth::user()->id;
                $payslip->save();
            }
            return redirect()->back()->with(['success'=>'Slip Gaji Berhasil Dibuat']);    
        }else{
            return redirect()->back()->with(['error'=>'Slip Gaji Sudah Pernah Dibuat']);  
        }  
    }

    public function payslipexport(request $request){
        $salary_month = $request->input('salary_month');      
        return Excel::download(new ExportToBca($salary_month), 'Paylisp-'.$salary_month.'.xlsx');
    }

    public function exportpdf($id){     
        $payslip = DB::table('pay_slips')->where('id',$id)->latest()->first();
        $employee = Karyawan::find($payslip->employee_id);
        $desgination = Designation::find($employee->designation_id);
        $signature = User::find($payslip->created_by);
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => storage_path().'/app/public/pdf',
            'format' => 'A4-L',
            'margin_left'=>20,
            'margin_right'=>20,
            'margin_top'=>10,
            'margin_bottom'=>15,
            'margin_header'=>10,
        ]);
        $mpdf->SetTitle($employee->name.' | '.date('Y-m'));
        $mpdf->WriteHTML(view('admin.slipgaji.export-pdf',compact('payslip','employee','desgination','signature')));
        $mpdf->Output();
    }


    public function slipgajibyemailback($id){
        $updateslip = Payslip::find($id);
        $updateslip->slipbyemail =0;
        $updateslip->save();
        return response()->json(compact('this'));
    }

    public function slipgajibyemail($id){
        $slipgaji = DB::table('pay_slips')->join('employees','pay_slips.employee_id','=','employees.id')
                    ->select('pay_slips.id','employees.name','employees.email','pay_slips.salary_month')
                    ->where('pay_slips.id',$id)->first();

            
        $komisidates="";
        $comissionmonths = date('m',strtotime($slipgaji->salary_month));
        if($comissionmonths == "01"){
            $komisidates  = "Januari";
        }else if($comissionmonths == "02"){
            $komisidates = "Februari";
        }else if($comissionmonths == "03"){
            $komisidates  = "Maret";
        }else if($comissionmonths == "04"){
            $komisidates = "April";
        }else if($comissionmonths == "05"){
            $komisidates = "Mei";
        }else if($comissionmonths == "06"){
            $komisidates = "Juni";
        }else if($comissionmonths == "07"){
            $komisidates = "July";
        }else if($comissionmonths == "08"){
            $komisidates = "Agustus";
        }else if($comissionmonths == "09"){
            $komisidates = "September";
        }else if($comissionmonths == "10"){
            $komisidates = "Oktober";
        }else if($comissionmonths == "11"){
            $komisidates = "November";
        }else if($comissionmonths == "12"){
            $komisidates = "Desember";
        }
        
       $ann = Announcement::where('month',$slipgaji->salary_month)->first();
       $catatan = "";
       if(isset($ann->announcement)){
           $catatan =$ann->announcement;
       }

        $data["email"]          = $slipgaji->email;
        $data["id"]             = $slipgaji->id;
        $data["client_name"]    = $slipgaji->name;
        $data["bulan"]          = $komisidates." ".date('Y',strtotime($slipgaji->salary_month));
        $data["subject"]        = "Slip Gaji ".$slipgaji->salary_month;
        $data["catatan"]        = $catatan;
        
    
        $pdf = PDF::loadView('admin.slipgaji.export-pdf-via-email', $data); 
        try{
            Mail::send('admin.slipgaji.sliptest', $data, function($message)use($data,$pdf) {
            $message->to($data["email"], $data["client_name"])
            ->subject($data["subject"])
            ->attachData($pdf->output(), "slipgaji-payroll-dss.pdf");
            });
        }catch(JWTException $exception){
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
             $this->statusdesc  =   "Error sending mail";
             $this->statuscode  =   "0";
 
        }else{
 
           $this->statusdesc  =   "Message sent Succesfully";
           $this->statuscode  =   "1";
        }
        $updateslip = Payslip::find($id);
        $updateslip->slipbyemail =1;
        $updateslip->save();
 
        return response()->json($updateslip);  
    }

    public function slipGajiDetailKaryawan($id){
        $payslips = Payslip::join('employees','pay_slips.employee_id','=','employees.id')
                    ->select('pay_slips.id','pay_slips.salary_month','employees.name','pay_slips.employee_id')
                    ->where('pay_slips.id',$id)
                    ->first();
        $allowance = Allowance::join('allowance_options','allowances.allowance_option','=','allowance_options.id')
                    ->select('allowances.id','allowance_options.name as jenis_pendapatan','allowances.amount','allowances.allowance_option','allowances.month')
                    ->where('allowances.employee_id',$payslips->employee_id)
                    ->where('allowances.month',$payslips->salary_month)
                    ->get();

        $deductions = SaturationDeduction::join('deduction_options','saturation_deductions.deduction_option','=','deduction_options.id')
                    ->select('saturation_deductions.id','deduction_options.name as jenis_pemotongan','saturation_deductions.amount','saturation_deductions.deduction_option','saturation_deductions.month')
                    ->where('saturation_deductions.employee_id',$payslips->employee_id)
                    ->where('saturation_deductions.month',$payslips->salary_month)
                    ->get();

        return view('admin.slipgaji.detailslipkaryawan',compact('payslips','allowance','deductions'));
    }

    public function updateSlipGajiDetailKaryawan(request $request, $id){
        $deductions_id  = $request->deductions_id;
        $allowances_id  = $request->allowances_id;
        
        $amount_deductions = str_replace(',','',str_replace('.', '', $request->amount_deductions));
        $amount_allowances = str_replace(',','',str_replace('.', '', $request->amount_allowances));
        
        $deductions = DB::table('saturation_deductions')->whereIn('id',$deductions_id)->get();
        $allowances = DB::table('allowances')->whereIn('id',$allowances_id)->get();
        foreach($deductions as $key => $row){
            DB::table('saturation_deductions')->where('id',$row->id)->update(array('amount'=> $amount_deductions[$key]));
        } 
        foreach($allowances as $key => $row){
            DB::table('allowances')->where('id',$row->id)->update(array('amount'=> $amount_allowances[$key]));
        } 
        $payslips = PaySlip::find($id);

        $payslips->net_payble             = Karyawan::updategajibersih($request->salary_month, $request->employee_id);
        $payslips->allowance              = Karyawan::updatetunjangan($request->salary_month, $request->employee_id);
        $payslips->saturation_deduction   = Karyawan::updatepengurangan($request->salary_month, $request->employee_id);
        $payslips->save(); 
        return redirect()->back();
    }

    public function slipGajiAnnouncement(request $request){
        $cek = Announcement::where('month',$request->month_email)->exists();
        if($cek){
          
            $announcement  = DB::table('announcement_email')->where('month',$request->month_email)->update([
                'announcement' =>$request->announcement,
            ]);
            return redirect()->back()->with(['success'=>'Penguman Email  Berhasil Dibuat']);  
        }else{
            $announcement               = new Announcement;
            $announcement->month        = $request->month_email;
            $announcement->announcement = $request->announcement;
            $announcement->save();
            return redirect()->back()->with(['success'=>'Penguman Email  Berhasil Dibuat']);  	
        }
        

    }





}
