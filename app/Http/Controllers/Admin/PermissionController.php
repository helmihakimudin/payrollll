<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Permission;
use Auth;

class PermissionController extends Controller
{
    public function index(){
        return view('admin.permission.index');
    }

    public function create(){
        return view('admin.permission.create');
    }

    public function permissionAjax(request $request){
        $column = array('name','guard_name','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $temp  = Permission::select('id','name','guard_name','id as actions');
       
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
   
                $obj['name']          = $row->name;
                $obj['guard_name']    = $row->guard_name;
                $obj['actions']       = '<a href="'.route('permission.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                                            <i class="la flaticon-edit"></i>
                                        </a>
                                        <a href="'.route('permission.destroy',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                                            <i class="la flaticon-delete"></i>
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

    public function store(request $request){

        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'guard_name'=>'required',

        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $permission = new Permission;
            $permission->name = $request->name;
            $permission->guard_name = $request->guard_name;
            $permission->save();
            return redirect()->route('permission')->with(['success'=>'Permission Berhasil Dibuat!']);
        }
        
    }

    public function edit($id){
        $permission = Permission::find($id);
      
        return view('admin.permission.edit',compact('permission'));
    }

    public function update(request $request, $id){

        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'guard_name'=>'required',

        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $permission = Permission::find($id);
            $permission->name = $request->name;
            $permission->guard_name = $request->guard_name;
            $permission->save();
            return redirect()->route('permission')->with(['success'=>'Permission Berhasil Diubah!']);
        }
        
    }

    public function destroy($id){
        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->route('permission')->with(['success'=>'Permission Berhasil Dihapus!']);
    }


}
