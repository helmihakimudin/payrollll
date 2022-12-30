<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Karyawan;
use Auth;
use DB;
use App\Cuti;
use App\Kasbon;
use App\Notification;
use App\Izin;
use App\Pengumuman;
use App\User;

class DashboardController extends Controller
{

    public function getnewpassword(Request $request){
        $karyawan = Karyawan::find(Auth::guard('emp')->user()->id);
        return response()->json($karyawan);
    }

    public function newpassword(Request $request){
        $karyawan = Karyawan::find(Auth::guard('emp')->user()->id);
        $karyawan->password = Hash::make($request->password);
        $karyawan->first_login_password = 0;
        $karyawan->save();
        return redirect()->back()->with(['success'=>'Selamat, Password Anda berhasil di perbarui']);
    }

    public function index(){
        $branch = DB::table('branches')->where('id',Auth::guard('emp')->user()->branch_id)->first();
        $branchname = "";
        if(isset($branch->name)){
            $branchname = $branch->name;
        }else{
            $branchname = "-";
        }
        $gender = DB::table('employees')->where('id',Auth::guard('emp')->user()->id)->first();
        $pengumuman = DB::table('announcement')->join("users","announcement.created_by","users.id")->select("users.name","announcement.*")->orderBy('id','DESC')->paginate(3);
        return view('karyawan.dashboard.index',compact('branchname','gender','pengumuman'));
    }

    public function cutiAjax(request $request){
        $column = array('type_leave','remark','notes','start_at','end_at','approval_check','created_by');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $employee_id = $request->input('employee_id');
        $temp  = Cuti::leftjoin('employees','paid_leave.employee_id','=','employees.id')
                ->leftjoin('departments','employees.department_id','=','departments.id')
                ->select('paid_leave.created_at','paid_leave.type_leave','paid_leave.remark','paid_leave.notes','paid_leave.start_at','paid_leave.end_at','paid_leave.approval_check','paid_leave.id','paid_leave.month','paid_leave.created_by')
                ->orderBy('paid_leave.created_at','DESC')
                ->where('paid_leave.employee_id',Auth::guard('emp')->user()->id);

        $total = $temp->count();
        $totalFiltered = $total;
    
        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(employees.name) LIKE '%".$search."%' OR LOWER(departments.name) LIKE '%".$search."%' OR LOWER(paid_leave.type_leave) LIKE '%".$search."%' OR LOWER(paid_leave.start_at) LIKE '%".$search."%' OR LOWER(paid_leave.end_at) LIKE '%".$search."%' OR LOWER(paid_leave.month) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                $createdby ="-";
                $user = User::find($row->created_by);
                if(isset($user->name)){
                    $createdby= $user->name;
                }else{
                    $createdby= '-';
                }
                $notes = "";
                if($row->notes != null){
                    $notes ='<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=showcutitolak(this); ><i class="flaticon-list"></i>Lihat</button>';
                }else{
                    $notes ='-';
                }
                $obj['created_at']      = date('d F Y',strtotime($row->created_at));
                $obj['type_leave']      = $row->type_leave;
                $obj['remark']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=show(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['notes']           = $notes;
                $obj['start_at']        = $row->start_at;
                $obj['end_at']          = $row->end_at;
               
                if($row->approval_check == 1){
                    $obj['approval_check']  = '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Disetujui</span>';  
                }elseif($row->approval_check == 2){
                    $obj['approval_check']  = '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Ditolak</span>';  
                }else{
                    $obj['approval_check']  = '<span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Menunggu</span>';  
                }
                $obj['created_by']      = $createdby;
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

    public function kasbonAjax(request $request){
        $column = array('created_at','amount','remark','notes','date_kasbon','approval_check');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $employee_id = $request->input('employee_id');
        $temp  = Kasbon::leftjoin('employees','kasbon.employee_id','=','employees.id')
                ->leftjoin('departments','kasbon.department_id','=','departments.id')
                ->select('kasbon.created_at','kasbon.amount','kasbon.remark','kasbon.notes','kasbon.date_kasbon','kasbon.approval_check','kasbon.id','kasbon.month','kasbon.created_by')
                ->orderBy('kasbon.created_at','DESC')
                ->where('kasbon.employee_id',Auth::guard('emp')->user()->id);

        $total = $temp->count();
        $totalFiltered = $total;
    
        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(employees.name) LIKE '%".$search."%' OR LOWER(departments.name) LIKE '%".$search."%' OR LOWER(kasbon.amount) LIKE '%".$search."%' OR LOWER(kasbon.remark) LIKE '%".$search."%' OR LOWER(kasbon.date_kasbon) LIKE '%".$search."%' OR LOWER(kasbon.month) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                $createdby ="-";
                $user = User::find($row->created_by);
                if(isset($user->name)){
                    $createdby= $user->name;
                }else{
                    $createdby= '-';
                }
                $obj['created_at']      = date("d F Y",strtotime($row->created_at));
                $obj['amount']          = "Rp.".number_format($row->amount,2,',','.');
                $obj['remark']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=show2(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['notes']           = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=shownotes2(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['date_kasbon']     = date('d F Y',strtotime($row->date_kasbon));     
                if($row->approval_check == 1){
                    $obj['approval_check']  = '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Disetujui</span>';  
                }elseif($row->approval_check == 2){
                    $obj['approval_check']  = '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Ditolak</span>';  
                }else{
                    $obj['approval_check']  = '<span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Menunggu</span>';  
                }
                $obj['created_by']      = $createdby;
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


    public function izinAjax(request $request){
        $column = array('type_leave','image','remark','notes','start_at','end_at','approval_check','created_by');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $employee_id = $request->input('employee_id');
        $temp  = Izin::leftjoin('employees','clearances.employee_id','=','employees.id')
                ->select('clearances.created_at','clearances.type_leave','clearances.remark','clearances.notes','clearances.start_at','clearances.end_at','clearances.approval_check','clearances.id','clearances.month','clearances.created_by')
                ->orderBy('clearances.created_at','DESC')
                ->where('clearances.employee_id',Auth::guard('emp')->user()->id);

        $total = $temp->count();
        $totalFiltered = $total;
    
        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(clearances.type_leave) LIKE '%".$search."%' OR LOWER(clearances.remark) LIKE '%".$search."%' OR LOWER(clearances.start_at) LIKE '%".$search."%' OR LOWER(clearances.end_at) LIKE '%".$search."%' OR LOWER(clearances.approval_check) LIKE '%".$search."%' OR LOWER(clearances.month) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                $createdby ="-";
                $user = User::find($row->created_by);
                if(isset($user->name)){
                    $createdby= $user->name;
                }else{
                    $createdby= '-';
                }
                $notes = "-";
                if($row->notes != null){
                    $notes = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=shownotes3(this); ><i class="flaticon-list"></i>Lihat</button>';
                }else{
                    $notes = '-';
                }
                $obj['type_leave']      = $row->type_leave;
                $obj['image']           = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=showImage(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['remark']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=show3(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['notes']           = $notes;
                $obj['start_at']        = date('d F Y',strtotime($row->start_at));  
                $obj['end_at']          = date('d F Y',strtotime($row->start_at));     
                if($row->approval_check == 1){
                    $obj['approval_check']  = '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Disetujui</span>';  
                }elseif($row->approval_check == 2){
                    $obj['approval_check']  = '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Ditolak</span>';  
                }else{
                    $obj['approval_check']  = '<span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Menunggu</span>';  
                }
                $obj['created_by']      = $createdby;
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

    public function pengumumanajax(request $request){
        $column = array('announcement_date','announcement','actions','created_by');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $employee_id = $request->input('employee_id');
        $temp  = Pengumuman::orderBy('created_at','DESC');
        $total = $temp->count();
        $totalFiltered = $total;
    
        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(announcement_date) LIKE '%".$search."%' OR LOWER(announcement) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                $createdby ="-";
                $user = User::find($row->created_by);
                if(isset($user->name)){
                    $createdby= $user->name;
                }else{
                    $createdby= '-';
                }
                $edit="-";
                $hapus="-";
                // if(Auth::user()->can('Edit Perusahaan')){
                    $edit='<a data-id="'.$row->id.'" onclick=editpengumuman(this); class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                                <i class="la flaticon-edit"></i>
                           </a>';

                           
                // }
                // if(Auth::user()->can('Hapus Perusahaan')){
                    $hapus='<a href="'.route('branch.destroy',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                                <i class="la flaticon-delete"></i>
                            </a>';
                // }
                $obj['announcement_date'] = date('d F Y',strtotime($row->announcement_date));
                $obj['announcement']      = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=showpengumuman(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['created_by']        = $createdby;
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

    public function show($id){
        $cuti = Cuti::find($id);
        return response()->json($cuti);
    }

    public function show2($id){
        $kasbon = Kasbon::find($id);
        return response()->json($kasbon);
    }

    public function show3($id){
        $izin = Izin::find($id);
        return response()->json($izin);
    }

    public function getKasbon(){
        $kasbon = Karyawan::select('amount_of_leave')->where('id',Auth::guard('emp')->user()->id)->first();
        $getkasbon = "Rp.".number_format($kasbon->amount_of_leave,2,',','.');
        return response()->json($getkasbon);
    }

    public function getCuti(){
        $paidleave = Karyawan::select('amount_paid_leave')->where('id',Auth::guard('emp')->user()->id)->first();
        if($paidleave->amount_paid_leave != null){
            $paidleave = $paidleave->amount_paid_leave;
        }else{
            $paidleave ="0";
        }
        $getpaidleave = "Total ".$paidleave;
        return response()->json($getpaidleave);
    }
    
    public function showpengumuman($id){
        $pengumuman = Pengumuman::find($id);
        return response()->json($pengumuman);
    }
    
  
}
