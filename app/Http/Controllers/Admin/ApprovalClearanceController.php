<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Izin;
use App\Events\IzinKaryawanEvent;
use Auth;
use App\user;

class ApprovalClearanceController extends Controller
{
    public function index(){
        return view('admin.approval-clearance.index');
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
        $temp  = Izin::leftjoin('employees','clearances.employee_id','=','employees.id')
                ->leftjoin('departments','employees.department_id','=','departments.id')
                ->select('employees.name','departments.name as department','clearances.type_leave','clearances.remark','clearances.start_at','clearances.end_at','clearances.month','clearances.approval_check','clearances.id')
                ->where('clearances.approval_check',0);

        $total = $temp->count();
        $totalFiltered = $total;
    
        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(employees.name) LIKE '%".$search."%' OR LOWER(departments.name) LIKE '%".$search."%' OR LOWER(clearances.type_leave) LIKE '%".$search."%' OR LOWER(clearances.start_at) LIKE '%".$search."%' OR LOWER(clearances.end_at) LIKE '%".$search."%' OR LOWER(clearances.month) LIKE '%".$search."%')")
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
                $obj['remark']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'" data-image="'.asset('storage/upload/surat/'.$row->image).'"  onclick=show(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['start_at']        = $row->start_at;
                $obj['end_at']          = $row->end_at;
                $obj['approval_check']  = '<a href="'.route('clearance.acc',['id' => $row->id]).'" class="btn btn-success btn-icon" title="Terima">
                                            <i class="fa fa-check"></i>
                                        </a>
                                        <a data-id="'.$row->id.'" onclick=modaldeclined(this);  class="btn btn-danger btn-icon" title="Tolak">
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
        $izin = Izin::find($id);
        $izin->approval_check = 1;
        $izin->created_by = Auth::user()->id;
        $izin->save();
        event(new IzinKaryawanEvent($name="izin", $description=Auth::user()->name." Menyetujui Pengajuan Izin Anda", $read_at = 2, $employee_id = $izin->employee_id));
        return redirect()->back()->with(['success'=>'disetujui']);
    }

    public function dec(request $request){
        $id = $request->input('id');
        $izin = Izin::find($id);
        $izin->approval_check = 2;
        $izin->created_by = Auth::user()->id;
        $izin->notes = $request->notes;
        $izin->save();
        event(new IzinKaryawanEvent($name="izin", $description=Auth::user()->name." Menolak Pengajuan Izin Anda", $read_at = 2, $employee_id = $izin->employee_id));
        return redirect()->back()->with(['success'=>'tidak disetujui']);
    }

    public function show($id){
        $cuti = Izin::find($id);
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
        $temp  = Izin::leftjoin('employees','clearances.employee_id','=','employees.id')
                ->leftjoin('departments','employees.department_id','=','departments.id')
                ->select('employees.name','departments.name as department','clearances.type_leave','clearances.remark','clearances.start_at','clearances.end_at','clearances.approval_check','clearances.month','clearances.id','clearances.created_by')
                ->where('clearances.approval_check', 1);

        $total = $temp->count();
        $totalFiltered = $total;
    
        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(employees.name) LIKE '%".$search."%' OR LOWER(departments.name) LIKE '%".$search."%' OR LOWER(clearances.type_leave) LIKE '%".$search."%' OR LOWER(clearances.start_at) LIKE '%".$search."%' OR LOWER(clearances.end_at) LIKE '%".$search."%' OR LOWER(clearances.month) LIKE '%".$search."%')")
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
        $temp  = Izin::leftjoin('employees','clearances.employee_id','=','employees.id')
                ->leftjoin('departments','employees.department_id','=','departments.id')
                ->select('employees.name','departments.name as department','clearances.type_leave','clearances.remark','clearances.start_at','clearances.end_at','clearances.approval_check','clearances.month','clearances.id','clearances.created_by')
                ->where('clearances.approval_check', 2);

        $total = $temp->count();
        $totalFiltered = $total;
    
        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(employees.name) LIKE '%".$search."%' OR LOWER(departments.name) LIKE '%".$search."%' OR LOWER(clearances.type_leave) LIKE '%".$search."%' OR LOWER(clearances.start_at) LIKE '%".$search."%' OR LOWER(clearances.end_at) LIKE '%".$search."%' OR LOWER(clearances.month) LIKE '%".$search."%')")
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
                $obj['department']      = $row->department;
                $obj['type_leave']      = $row->type_leave;
                $obj['remark']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=show(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['notes']           = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=showmodaldeclined(this); ><i class="flaticon-list"></i>Lihat</button>';
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
