<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\CutiKaryawanEvent;
use App\Cuti;
use Auth;
use App\User;
use App\Karyawan;

class ApprovalPLController extends Controller
{
    public function index(){
        return view('admin.approval-paidleave.index');
    }

    public function request(request $request){
        $column = array('name','department','type_leave','remark','start_at','end_at','approval_check');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $employee_id = $request->input('employee_id');
        $temp  = Cuti::leftjoin('employees','paid_leave.employee_id','=','employees.id')
                ->leftjoin('departments','employees.department_id','=','departments.id')
                ->select('employees.name','departments.name as department','paid_leave.type_leave','paid_leave.remark','paid_leave.start_at','paid_leave.end_at','paid_leave.month','paid_leave.approval_check','paid_leave.id')
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
            $boot   = $temp->whereRaw("( LOWER(employees.name) LIKE '%".$search."%' OR LOWER(departments.name) LIKE '%".$search."%' OR LOWER(paid_leave.type_leave) LIKE '%".$search."%' OR LOWER(paid_leave.month) LIKE '%".$search."%' OR LOWER(paid_leave.start_at) LIKE '%".$search."%' OR LOWER(paid_leave.end_at) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                $obj['name']            = $row->name;
                $obj['department']      = $row->department;
                $obj['type_leave']      = $row->type_leave;
                $obj['remark']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'" onclick=show(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['start_at']        = $row->start_at;
                $obj['end_at']          = $row->end_at;
                $obj['approval_check']  = '<a href="'.route('pay-leave.acc',['id' => $row->id]).'" class="btn btn-success btn-icon" title="Terima">
                                            <i class="fa fa-check"></i>
                                        </a>
                                        <a data-id="'.$row->id.'" onclick=showdeclined(this);   class="btn btn-danger btn-icon" title="Tolak">
                                            <i class="flaticon-close"></i>
                                        </a>';

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

    public function acc($id){
        $cuti = Cuti::find($id);
        $cuti->approval_check = 1;
        $cuti->created_by = Auth::user()->id;
        $cuti->save();
        $karyawan = Karyawan::find($cuti->employee_id);
        $amountpaid =   $karyawan->amount_paid_leave;
        $result = $amountpaid -1;
        $karyawan->amount_paid_leave  = $result;
        $karyawan->save();
        event(new CutiKaryawanEvent($name="cuti", $description=Auth::user()->name." Menyetujui Pengajuan Cuti Anda ", $read_at=2, $employee_id = $cuti->employee_id));
        return redirect()->back()->with(['success'=>'disetujui']);
    }

    public function dec(request $request){
        $id = $request->input('id');
        $cuti = Cuti::find($id);
        $cuti->approval_check = 2;
        $cuti->created_by = Auth::user()->id;
        $cuti->notes = $request->notes;
        $cuti->save();
        event(new CutiKaryawanEvent($name="cuti", $description=Auth::user()->name." Menolak Pengajuan Cuti Anda ", $read_at=2, $employee_id = $cuti->employee_id));
        return redirect()->back()->with(['success'=>'tidak disetujui']);
    }

    public function show($id){
        $cuti = Cuti::find($id);
        return response()->json($cuti);
    }

    public function accepted(request $request){
        $column = array('name','department','type_leave','remark','start_at','end_at','approval_check','created_by');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $employee_id = $request->input('employee_id');
        $temp  = Cuti::leftjoin('employees','paid_leave.employee_id','=','employees.id')
                ->leftjoin('departments','employees.department_id','=','departments.id')
                ->select('employees.name','departments.name as department','paid_leave.type_leave','paid_leave.remark','paid_leave.start_at','paid_leave.end_at','paid_leave.approval_check','paid_leave.id','paid_leave.month','paid_leave.created_by')
                ->where('paid_leave.approval_check', 1)
                ->OrderBy('paid_leave.created_at','DESC');

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
                $obj['name']            = $row->name;
                $obj['name']            = $row->name;
                $obj['department']      = $row->department;
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
        $column = array('name','department','type_leave','remark','notes','start_at','end_at','approval_check','created_by');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $employee_id = $request->input('employee_id');
        $temp  = Cuti::leftjoin('employees','paid_leave.employee_id','=','employees.id')
                ->leftjoin('departments','employees.department_id','=','departments.id')
                ->select('employees.name','departments.name as department','paid_leave.type_leave','paid_leave.remark','paid_leave.notes','paid_leave.start_at','paid_leave.end_at','paid_leave.approval_check','paid_leave.month','paid_leave.id','paid_leave.created_by')
                ->where('paid_leave.approval_check', 2)
                ->OrderBy('paid_leave.created_at','DESC');

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
                $obj['name']            = $row->name;
                $obj['name']            = $row->name;
                $obj['department']      = $row->department;
                $obj['type_leave']      = $row->type_leave;
                $obj['remark']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=show(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['notes']           = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=show2(this); ><i class="flaticon-list"></i>Lihat</button>';
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
}
