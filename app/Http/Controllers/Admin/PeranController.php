<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Peran;
// use App\Permission;
use App\RoleHasPermission;
use Validator;
use DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PeranController extends Controller
{
    public function index(){
        if(auth()->user()->can('Manage Peran')){
            return view('admin.peran.index');
        }
    }

    public function create(){
        return view('admin.peran.create');
    }

    public function peranAjax(request $request){
        $column = array('name','guard_name','permission','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = Peran::select('id','name','guard_name','id as actions');

        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(name) LIKE '%".$search."%' OR LOWER(guard_name) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $haspermission = RoleHasPermission::where('role_id',$row->id)->get();
                $arrayHas = array();
                foreach($haspermission as $rows){
                    $permission = Permission::where('id',$rows->permission_id)->first();
                    if(isset($permission->name)){
                        $arrayHas [] = '<div class="kt-badge kt-badge--primary kt-badge--inline kt-badge--pill m-1 text-justify">'.$permission->name.'</div>';
                    }

                }
                $obj['name']          = $row->name;
                $obj['guard_name']    = $row->guard_name;
                $obj['permission']    = $arrayHas;
                $obj['actions']       = '<a href="javascript:;" data-attr="'.route('peran.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit" title="Edit">
                                            <i class="la flaticon-edit"></i>
                                        </a>
                                        <a href="javascript:;" data-attr="'.route('peran.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show" title="Deleted">
                                            <i class="la flaticon-delete"></i>
                                        </a>';
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

    public function show($id){
        $peran = Peran::find($id);
        return view('admin.peran.show',compact('peran'));
    }

    public function edit($id){
        $peran = Peran::find($id);
        $haspermission = RoleHasPermission::where('role_id',$id)->get();
        $arraypermission = array();
        foreach($haspermission as $row){
            $arraypermission [] = $row->permission_id;
        }
        return view('admin.peran.edit',compact('peran','haspermission','arraypermission'));
    }

    public function store(request $request){

        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'guard_name'=>'required',

        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $peran = new Peran;
            $peran->name = $request->name;
            $peran->guard_name = $request->guard_name;
            $peran->created_by = Auth::user()->id;
            $peran->save();

            $permission = $request->permission_id;
            foreach($permission as $i => $row){
                $p    = Permission::where('id', '=', $row)->firstOrFail();
                $role = Role::where('name', '=', $peran->name)->first();
                $role->givePermissionTo($p);

            }
            return redirect()->route('peran')->with(['success'=>'Rules Successfull Created !']);
        }

    }
    public function update(request $request,$id){

        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'guard_name'=>'required',

        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $peran =  Peran::find($id);
            $peran->name = $request->name;
            $peran->guard_name = $request->guard_name;
            $peran->created_by = Auth::user()->id;
            $peran->save();
            $permission = $request->permission_id;
            $destroy = DB::table('role_has_permissions')->where('role_id',$id)->delete();
            foreach($permission as $row){
                $p    = Permission::where('id', '=', $row)->firstOrFail();
                $role = Role::where('name', '=', $peran->name)->first();
                $role->givePermissionTo($p);
            }
            return redirect()->route('peran')->with(['success'=>'Rules Successfull Updated ']);
        }

    }

    public function destroy($id){
        $peran = Peran::find($id);
        $permission = RoleHasPermission::where('role_id',$id);
        $peran->delete();
        $permission->delete();
        return redirect()->route('peran')->with(['success'=>'Rules Successfull Deleted !']);
    }
}
