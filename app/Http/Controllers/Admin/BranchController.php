<?php

namespace App\Http\Controllers\Admin;

use App\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.branch.index");
    }

    public function getBranch(request $request){
        $column = array('name','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $temp  = Branch::select('id','name','id as actions');
       
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
                $edit="-";
                $hapus="-";
                if(Auth::user()->can('Edit Perusahaan')){
                    $edit='<a href="javascript:;" data-attr="'.route('branch.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md  btn-edit" title="Edit">
                                <i class="la flaticon-edit"></i>
                           </a>';
                }
                if(Auth::user()->can('Hapus Perusahaan')){
                    $hapus='<a href="javascript:;" data-attr="'.route('branch.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md  btn-show" title="Edit">
                                <i class="la flaticon-delete"></i>
                            </a>';
                }
                $obj['name']    = $row->name;
                $obj['actions']       = $edit.''.$hapus;
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
        return view('admin.branch.create');
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
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
     
                $branch = new Branch;
                $branch->name = $request->name;
                $branch->created_by = $request->created_by;
                $branch->save();
            return redirect()->route('branch.index')->with(['success'=>'Company Successfull created !']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $branch = Branch::find($id);
        return view('admin.branch.show',compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch = Branch::find($id);
        return view('admin.branch.edit',compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' =>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $branch = Branch::find($id);
            $branch->name = $request->name;
            $branch->created_by = $request->created_by;
            $branch->save();
            return redirect()->route('branch.index')->with(['success'=>'Company Successfull updated !']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::find($id);
        $branch->delete();
        return redirect()->route('branch.index')->with(['success'=>'Company Successfull deleted !!']);
    }
}
