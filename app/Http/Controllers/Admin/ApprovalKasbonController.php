<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kasbon;
use App\Karyawan;
use App\Events\KasbonKaryawanEvent;
use Auth;
use App\User;

class ApprovalKasbonController extends Controller
{
    public function index(){
        return view('admin.approval-kasbon.index');
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
        $temp  = Kasbon::leftjoin('employees','kasbon.employee_id','=','employees.id')
        ->leftjoin('departments','kasbon.department_id','=','departments.id')
        ->select('employees.name','departments.name as department','kasbon.amount','kasbon.remark','kasbon.date_kasbon','kasbon.approval_check','kasbon.month','kasbon.id')
        ->where('kasbon.approval_check', 0);

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
                $obj['name']            = $row->name;
                $obj['department']      = $row->department;
                $obj['amount']          = "Rp.".number_format($row->amount,2,',','.');
                $obj['remark']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=show(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['date_kasbon']     = date('d F Y',strtotime($row->date_kasbon));     
                $obj['approval_check']  = '<button type="button" class="btn btn-success btn-icon" data-id="'.$row->id.'"  onclick=openacc(this);  title="Terima"><i class="fa fa-check"></i></button>
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
        $kasbon = Kasbon::find($id);
        $kasbon->approval_check = 1;
        $kasbon->created_by = Auth::user()->id;
        $kasbon->save();
        return redirect()->back()->with(['success'=>'disetujui']);
    }

    public function dec(request $request){
        $id = $request->input('id');
        $kasbon = Kasbon::find($id);
        $kasbon->approval_check = 2;
        $kasbon->notes = $request->notes;
        $kasbon->created_by = Auth::user()->id;
        $kasbon->save();
        event(new KasbonKaryawanEvent($name="kasbon", $description=Auth::user()->name." Menolak Kasbon  Anda Senilai ". "Rp.".number_format($kasbon->amount,2,',','.'), $read_at=2,$employee_id = $kasbon->employee_id));
        return redirect()->back()->with(['success'=>'tidak disetujui']);
    }

    public function show($id){
        $cuti = Kasbon::find($id);
        return response()->json($cuti);
    }

    public function accepted(request $request){
        $column = array('name','department','amount','amount_accepted','remark','start_at','end_at','approval_check','created_by');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $employee_id = $request->input('employee_id');
        $temp  = Kasbon::leftjoin('employees','kasbon.employee_id','=','employees.id')
        ->leftjoin('departments','kasbon.department_id','=','departments.id')
        ->select('employees.name','departments.name as department','kasbon.amount','kasbon.amount_accepted','kasbon.remark','kasbon.date_kasbon','kasbon.approval_check','kasbon.month','kasbon.id','kasbon.created_by')
        ->where('kasbon.approval_check', 1);

        $total = $temp->count();
        $totalFiltered = $total;
    
        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(employees.name) LIKE '%".$search."%' OR LOWER(departments.name) LIKE '%".$search."%' OR LOWER(kasbon.amount) LIKE '%".$search."%' OR LOWER(kasbon.amount_accepted) LIKE '%".$search."%' OR LOWER(kasbon.remark) LIKE '%".$search."%' OR LOWER(kasbon.date_kasbon) LIKE '%".$search."%' OR LOWER(kasbon.month) LIKE '%".$search."%')")
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
                $obj['amount']          = "Rp.".number_format($row->amount,2,',','.');
                $obj['amount_accepted'] = "Rp.".number_format($row->amount_accepted,2,',','.');
                $obj['remark']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=show(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['date_kasbon']     = date('d F Y',strtotime($row->date_kasbon));     
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
        $temp  = Kasbon::leftjoin('employees','kasbon.employee_id','=','employees.id')
        ->leftjoin('departments','kasbon.department_id','=','departments.id')
        ->select('employees.name','departments.name as department','kasbon.amount','kasbon.remark','kasbon.notes','kasbon.date_kasbon','kasbon.approval_check','kasbon.month','kasbon.id','kasbon.created_by')
        ->where('kasbon.approval_check', 2)
        ->orderBy('kasbon.created_at','DESC');

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
                $obj['name']            = $row->name;
                $obj['department']      = $row->department;
                $obj['amount']          = "Rp.".number_format($row->amount,2,',','.');
                $obj['remark']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=show(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['notes']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=showDeclined(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['date_kasbon']     = date('d F Y',strtotime($row->date_kasbon));     
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
        
        $karyawan = Karyawan::find($request->uid);
        if($karyawan->amount_of_leave != null){
            if($request->typeacc == 'Sebagian')
            {
                $karyawan->amount_of_leave += $request->amount_of_leave;
            }
            else{
                $karyawan->amount_of_leave += $request->amount;
            }
        }
        else{
            if($request->typeacc == 'Sebagian')
            {
                $karyawan->amount_of_leave = $request->amount_of_leave;
            }
            else{
                $karyawan->amount_of_leave = $request->amount;
            }
        }
        $karyawan->save();
       
        $kasbon =  Kasbon::find($request->id);
        if($request->typeacc == 'Sebagian'){
            $kasbon->amount_accepted = $request->amount_of_leave;
          
        }
        else{
            $kasbon->amount_accepted = $request->amount;
        }
        $kasbon->approval_check = 1;
        $kasbon->notes       = $request->notes;
        $kasbon->created_by  = Auth::user()->id;
        $kasbon->save();
        event(new KasbonKaryawanEvent($name="kasbon", $description=Auth::user()->name." Menyetujui Kasbon  Anda Senilai ". "Rp.".number_format($kasbon->amount_accepted,2,',','.'), $read_at=2,$employee_id = $karyawan->id));
        
        return redirect()->back()->with(['success'=>'Izin berhasil diajukan!']);
    }
}
