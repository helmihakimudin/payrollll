<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Izin;
use Illuminate\Support\Facades\Storage;
use App\Events\IzinEvent;
use Auth;
use App\User;

class IzinController extends Controller
{
    public function index(){
        return view('karyawan.izin.index');
    }

    public function IzinAjax(request $request){
        $column = array('created_at','type_leave','remark','start_at','end_at','approval_check');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $employee_id = $request->input('employee_id');
        $temp  = Izin::leftjoin('employees','clearances.employee_id','=','employees.id')
                ->select('clearances.created_at','clearances.type_leave','clearances.remark','clearances.remark','clearances.start_at','clearances.end_at','clearances.approval_check','clearances.month','clearances.id')
                ->orderBy('clearances.id','DESC')
                ->where('clearances.employee_id',Auth::guard('karyawan')->user()->id)
                ->where('clearances.approval_check', 0);

        $total = $temp->count();
        $totalFiltered = $total;
    
        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(employees.name) LIKE '%".$search."%'OR LOWER(clearances.remark) LIKE '%".$search."%' OR LOWER(clearances.type_leave) LIKE '%".$search."%' OR LOWER(clearances.month) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                $obj['created_at']      = date("d F Y",strtotime($row->created_at)); 
                $obj['type_leave']      = $row->type_leave;
                $obj['remark']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=show(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['start_at']        = date("d F Y",strtotime($row->start_at)); 
                $obj['end_at']          = date("d F Y",strtotime($row->end_at));    
                $obj['approval_check']  = '<span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Waiting</span>';  
             
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
        $column = array('name','department','type_leave','remark','start_at','end_at','approval_check','created_by');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $employee_id = $request->input('employee_id');
        $temp  = Izin::leftjoin('employees','clearances.employee_id','=','employees.id')
        ->select('clearances.created_at','clearances.type_leave','clearances.remark','clearances.remark','clearances.start_at','clearances.end_at','clearances.approval_check','clearances.month','clearances.id','clearances.created_by')
        ->orderBy('clearances.id','DESC')
        ->where('clearances.employee_id',Auth::guard('karyawan')->user()->id)
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
            $boot   = $temp->whereRaw("( LOWER(employees.name) LIKE '%".$search."%' OR LOWER(clearances.type_leave) LIKE '%".$search."%' OR LOWER(clearances.start_at) LIKE '%".$search."%' OR LOWER(clearances.end_at) LIKE '%".$search."%' OR LOWER(clearances.month) LIKE '%".$search."%')")
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
                $obj['type_leave']      = $row->type_leave;
                $obj['remark']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=show(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['start_at']        = date("d F Y",strtotime($row->start_at)); 
                $obj['end_at']          = date("d F Y",strtotime($row->end_at));    
                $obj['approval_check']  = '<span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Approved</span>';
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
        ->select('clearances.created_at','clearances.type_leave','clearances.remark','clearances.remark','clearances.start_at','clearances.end_at','clearances.approval_check','clearances.id','clearances.month','clearances.created_by')
        ->orderBy('clearances.id','DESC')
        ->where('clearances.employee_id',Auth::guard('karyawan')->user()->id)
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
            $boot   = $temp->whereRaw("( LOWER(employees.name) LIKE '%".$search."%'OR LOWER(clearances.type_leave) LIKE '%".$search."%' OR LOWER(clearances.start_at) LIKE '%".$search."%' OR LOWER(clearances.end_at) LIKE '%".$search."%' OR LOWER(clearances.month) LIKE '%".$search."%')")
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
                $obj['type_leave']      = $row->type_leave;
                $obj['remark']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=show(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['notes']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=showmodaldeclined(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['start_at']        = date("d F Y",strtotime($row->start_at)); 
                $obj['end_at']          = date("d F Y",strtotime($row->end_at));    
                $obj['approval_check']  = '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Declined</span>';
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
        
        $izin = new Izin;
        $user = User::all();
        $izin->employee_id  = Auth::guard('karyawan')->user()->id;
        $izin->type_leave   = $request->type_leave;
        if($request->type_leave == 'Sakit'){
            if($request->file('image') != null){
                $expFile = explode('.', $request->file('image')->getClientOriginalName());
                $newName = str_shuffle(sha1($expFile[0])) . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->storeAs('public/surat-sakit', $newName);
                $izin->image        = $newName;
            }else{
                return redirect()->back()->with(['error'=>'izin sakit wajib upload surat sakit !']);
            }
        }
        else{
            $izin->image        = null;
        }
        $izin->remark       = $request->remark;
        $izin->start_at     = date('Y-m-d',strtotime($request->start_at));
        $izin->end_at       = date('Y-m-d',strtotime($request->end_at));
        $izin->month        = date('Y-m');
        $izin->save();
        foreach($user as $users){
            event(new IzinEvent($name="izin", $description=Auth::guard('karyawan')->user()->name." Mengajukan ".$request->type_leave." ".$request->remark, $admin = $users->id));
        }
        
        
        return redirect()->back()->with(['success'=>'Izin berhasil diajukan!']);
    }

    public function show($id){
        $izin = Izin::find($id);
        return response()->json($izin);
    }
}
