<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cuti;
use App\Karyawan;
use App\Events\CutiEvent;
use Auth;
use App\User;

class CutiController extends Controller
{
    public function index(){
        $paidleave = Karyawan::select('amount_paid_leave')->where('id',Auth::guard('karyawan')->user()->id)->first();
        $getpaidleave = $paidleave->amount_paid_leave;
        return view('karyawan.cuti.index', compact('getpaidleave'));
    }
    public function cutiAjax(request $request){
        $column = array('type_leave','remark','start_at','end_at','approval_check');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $employee_id = $request->input('employee_id');
        $temp  = Cuti::leftjoin('employees','paid_leave.employee_id','=','employees.id')
                ->leftjoin('departments','employees.department_id','=','departments.id')
                ->select('paid_leave.created_at','paid_leave.type_leave','paid_leave.remark','paid_leave.start_at','paid_leave.end_at','paid_leave.approval_check','paid_leave.month','paid_leave.id')
                ->orderBy('paid_leave.id','DESC')
                ->where('paid_leave.employee_id',Auth::guard('karyawan')->user()->id)
                ->where('paid_leave.approval_check', 0);

        $total = $temp->count();
        $totalFiltered = $total;
    
        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(employees.name) LIKE '%".$search."%' OR LOWER(departments.name) LIKE '%".$search."%' OR LOWER(paid_leave.type_leave) LIKE '%".$search."%' OR LOWER(paid_leave.start_at) LIKE '%".$search."%' OR LOWER(paid_leave.end_at) LIKE '%".$search."%'OR LOWER(paid_leave.month) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                $obj['created_at']      = date('d F Y',strtotime($row->created_at));
                $obj['type_leave']      = $row->type_leave;
                $obj['remark']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=show(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['start_at']        = $row->start_at;
                $obj['end_at']          = $row->end_at;
                $obj['approval_check']  = '<span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Menunggu</span>';  
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

    public function accepted(request $request){
        $column = array('type_leave','remark','start_at','end_at','approval_check');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $employee_id = $request->input('employee_id');
        $temp  = Cuti::leftjoin('employees','paid_leave.employee_id','=','employees.id')
                ->leftjoin('departments','employees.department_id','=','departments.id')
                ->select('paid_leave.created_at','paid_leave.type_leave','paid_leave.remark','paid_leave.start_at','paid_leave.end_at','paid_leave.month','paid_leave.approval_check','paid_leave.id','paid_leave.created_by')
                ->orderBy('paid_leave.id','DESC')
                ->where('paid_leave.employee_id',Auth::guard('karyawan')->user()->id)
                ->where('paid_leave.approval_check', 1);

        $total = $temp->count();
        $totalFiltered = $total;
    
        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(employees.name) LIKE '%".$search."%' OR LOWER(departments.name) LIKE '%".$search."%' OR LOWER(paid_leave.month) LIKE '%".$search."%' OR LOWER(paid_leave.remark) LIKE '%".$search."%')")
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
                $obj['created_at']      = date('d F Y',strtotime($row->created_at));
                $obj['type_leave']      = $row->type_leave;
                $obj['remark']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=show(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['start_at']        = $row->start_at;
                $obj['end_at']          = $row->end_at;
                $obj['approval_check']  = '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Disetujui</span>';
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

    public function rejected(request $request){
        $column = array('type_leave','notes','start_at','end_at','approval_check');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $employee_id = $request->input('employee_id');
        $temp  = Cuti::leftjoin('employees','paid_leave.employee_id','=','employees.id')
                ->leftjoin('departments','employees.department_id','=','departments.id')
                ->select('paid_leave.created_at','paid_leave.type_leave','paid_leave.notes','paid_leave.start_at','paid_leave.end_at','paid_leave.approval_check','paid_leave.created_by','paid_leave.month','paid_leave.id')
                ->orderBy('paid_leave.id','DESC')
                ->where('paid_leave.employee_id',Auth::guard('karyawan')->user()->id)
                ->where('paid_leave.approval_check', 2);

        $total = $temp->count();
        $totalFiltered = $total;
    
        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(employees.name) LIKE '%".$search."%' OR LOWER(departments.name) LIKE '%".$search."%' OR LOWER(paid_leave.remark) LIKE '%".$search."%'OR LOWER(paid_leave.month) LIKE '%".$search."%')")
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
                $obj['created_at']      = date('d F Y',strtotime($row->created_at));
                $obj['type_leave']      = $row->type_leave;
                $obj['notes']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=shownotes(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['start_at']        = $row->start_at;
                $obj['end_at']          = $row->end_at;
                $obj['approval_check']  = '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Ditolak</span>';
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

    public function store(request $request){
        $karyawan = Karyawan::find(Auth::guard('karyawan')->user()->id);
        $user = User::all();
        if($karyawan->amount_paid_leave !=0){
            $cuti = new Cuti;
            $cuti->employee_id  = Auth::guard('karyawan')->user()->id;
            $cuti->type_leave   = $request->type_leave;
            if($request->type_leave == 'Cuti Khusus Penting'){
                $cuti->remark       = $request->remark;
            }else{
                $cuti->remark       = $request->type_leave;
            }
            $cuti->start_at     = date('Y-m-d',strtotime($request->start_at));
            $cuti->end_at       = date('Y-m-d',strtotime($request->end_at));
            $cuti->month        = date('Y-m');
            $cuti->save();
            foreach($user as $users){
                event(new CutiEvent($name="cuti", $description=Auth::guard('karyawan')->user()->name." Mengajukan ".$request->type_leave." ".$request->remark,$admin = $users->id));
            }
            
        }else{
            return redirect()->back()->with(['error'=>'massa cuti sudah habis !']);
        }
        return redirect()->back()->with(['success'=>'cuti berhasil diajukan!']);
    }

    public function show($id){
        $cuti = Cuti::find($id);
        return response()->json($cuti);
    }

}
