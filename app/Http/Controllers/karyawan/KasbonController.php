<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kasbon;
use App\Events\KasbonEvent;
use Auth;
use App\Karyawan;
use App\User;


class KasbonController extends Controller
{
    public function index(){
        return view('karyawan.kasbon.index');
    }


    public function kasbonAjax(request $request){
        $column = array('created_at','amount','remark','date_kasbon','approval_check');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $employee_id = $request->input('employee_id');
        $temp  = Kasbon::leftjoin('employees','kasbon.employee_id','=','employees.id')
                ->leftjoin('departments','kasbon.department_id','=','departments.id')
                ->select('kasbon.created_at','kasbon.amount','kasbon.remark','kasbon.date_kasbon','kasbon.approval_check','kasbon.created_by','kasbon.month','kasbon.id','kasbon.created_by')
                ->orderBy('kasbon.id','DESC')
                ->where('kasbon.employee_id',Auth::guard('karyawan')->user()->id)
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
                $obj['created_at']      = date("d F Y",strtotime($row->created_at));
                $obj['amount']          = "Rp.".number_format($row->amount,2,',','.');
                $obj['remark']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=show(this); ><i class="flaticon-list"></i>Lihat</button>';
                $obj['date_kasbon']     = date('d F Y',strtotime($row->date_kasbon));     
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

    public function store(request $request){
        $user = User::all();
        $kasbon                 = new Kasbon;
        $karyawan               = Karyawan::find(Auth::guard('karyawan')->user()->id);
        $kasbon->employee_id    = Auth::guard('karyawan')->user()->id;
        $kasbon->department_id  = $karyawan->department_id;
        $kasbon->amount         = $request->amount;
        $kasbon->remark         = $request->remark;
        $kasbon->date_kasbon    = date('Y-m-d',strtotime($request->date_kasbon));
        $kasbon->month          = date('Y-m');
        $kasbon->save();
        foreach($user as $users){
            event(new KasbonEvent($name="kasbon", $description=Auth::guard('karyawan')->user()->name." Mengajukan kasbon ". "Rp.".number_format($request->amount,2,',','.'),$admin = $users->id));
        }
       
        return redirect()->back()->with(['success'=>'kasbon berhasil diajukan!']);
    }

    public function show($id){
        $kasbon = Kasbon::find($id);
        return response()->json($kasbon);
    }

    public function accepted(request $request){
        $column = array('created_at','amount','amount_accepted','notes','date_kasbon','approval_check');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $employee_id = $request->input('employee_id');
        $temp  = Kasbon::leftjoin('employees','kasbon.employee_id','=','employees.id')
        ->leftjoin('departments','kasbon.department_id','=','departments.id')
        ->select('kasbon.created_at','kasbon.amount','kasbon.amount_accepted','kasbon.notes','kasbon.date_kasbon','kasbon.approval_check','kasbon.id','kasbon.month','kasbon.created_by')
        ->orderBy('kasbon.id','DESC')
        ->where('kasbon.employee_id',Auth::guard('karyawan')->user()->id)
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
                $obj['created_at']      = date("d F Y",strtotime($row->created_at));
                $obj['amount']          = "Rp.".number_format($row->amount,2,',','.');
                $obj['amount_accepted'] = "Rp.".number_format($row->amount_accepted,2,',','.');
                $obj['notes']          = '<button type="button" class="btn btn-primary btn-sm" data-id="'.$row->id.'"  onclick=showApproved(this); ><i class="flaticon-list"></i>Lihat</button>';
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
        $column = array('created_at','amount','notes','date_kasbon','approval_check');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $employee_id = $request->input('employee_id');
        $temp  = Kasbon::leftjoin('employees','kasbon.employee_id','=','employees.id')
        ->leftjoin('departments','kasbon.department_id','=','departments.id')
        ->select('kasbon.created_at','kasbon.amount','kasbon.notes','kasbon.date_kasbon','kasbon.approval_check','kasbon.id','kasbon.month','kasbon.created_by')
        ->orderBy('kasbon.id','DESC')
        ->where('kasbon.employee_id', Auth::guard('karyawan')->user()->id)
        ->where('kasbon.approval_check', 2);

        $total = $temp->count();
        $totalFiltered = $total;
    
        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(employees.name) LIKE '%".$search."%' OR LOWER(departments.name) LIKE '%".$search."%' OR LOWER(kasbon.amount) LIKE '%".$search."%' OR LOWER(kasbon.remark) LIKE '%".$search."%' OR LOWER(kasbon.date_kasbon) LIKE '%".$search."%'OR LOWER(kasbon.month) LIKE '%".$search."%')")
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
                $obj['amount']          = "Rp.".number_format($row->amount,2,',','.');;
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
}
