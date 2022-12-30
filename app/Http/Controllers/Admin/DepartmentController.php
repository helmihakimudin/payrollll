<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.department.index');
    }

    public function getDepartment(request $request){
        $column = array('name', 'branch_id', 'actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $temp  = DB::table('departments')
        ->leftJoin('branches', 'departments.branch_id', 'branches.id' )
        ->select(DB::raw('branches.name as branch'), 'departments.name', 'departments.id');
       
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(name) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $edit  = "-";
                $hapus = "-";
                if(Auth::user()->can('Edit Departemen')){
                    $edit = '<a href="javascript:;" data-attr="'.route('department.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit" title="Edit">
                                <i class="la flaticon-edit"></i>
                             </a>';
                }
                if(Auth::user()->can('Hapus Departemen')){
                    $hapus = '<ahref="javascript:;"  data-attr="'.route('department.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show" title="Edit">
                                    <i class="la flaticon-delete"></i>
                              </a>';
                }
                $obj['name']        = $row->name;
                $obj['branch']      = $row->branch;
                $obj['actions']     = $edit.''.$hapus;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.department.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' =>'required',
            'branch_id' =>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
     
            $department = new Department;
            $department->name = $request->name;
            $department->created_by = $request->created_by;
            $department->branch_id = $request->branch_id;
            $department->save();
            return redirect()->route('department.index')->with(['success'=>'Department Successfull Created !']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $department = Department::find($id);
        return view('admin.department.show',compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::find($id);
        $branch = Branch::get();
        $selectedBranch = $department->branch_id;
        return view('admin.department.edit',compact('department', 'branch', 'selectedBranch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' =>'required',
            'branch_id' =>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $department = Department::find($id);
            $department->name = $request->name;
            $department->created_by = $request->created_by;
            $department->branch_id = $request->branch_id;
            $department->save();
            return redirect()->route('department.index')->with(['success'=>'Department Successfull Updated !']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::find($id);
        $department->delete();
        return redirect()->route('department.index')->with(['success'=>'Department Successfull Deleted !']);
    }
}
