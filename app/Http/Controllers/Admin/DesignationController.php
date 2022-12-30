<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Designation;
use Validator;
use Auth;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.designation.index");
    }

    public function getDesignation(request $request){
        $column = array('name','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $temp  = Designation::select('id','name','id as actions');
       
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
                $edit  ="-";
                $hapus = "-";
                if(Auth::user()->can('Edit Jabatan')){
                    $edit='<a href="javasript:;" data-attr="'.route('designation.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit" title="Edit">
                                <i class="la flaticon-edit"></i>
                            </a>';
                }
                if(Auth::user()->can('Hapus Jabatan')){
                    $hapus = '<a href="javasript:;" data-attr="'.route('designation.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show" title="Delete">
                                    <i class="la flaticon-delete"></i>
                             </a>';
                }
                $obj['name']    = $row->name;
                $obj['actions'] = $edit.''.$hapus;
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
        return view('admin.designation.create');
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
     
                $designation = new Designation;
                $designation->name = $request->name;
                $designation->created_by = $request->created_by;
                $designation->save();
            return redirect()->route('designation.index')->with(['success'=>'Position successfull created !']);
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
        $designation = Designation::find($id);
        return view('admin.designation.show',compact('designation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $designation = Designation::find($id);
        return view('admin.designation.edit',compact('designation'));
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
            $designation = Designation::find($id);
            $designation->name = $request->name;
            $designation->created_by = $request->created_by;
            $designation->save();
            return redirect()->route('designation.index')->with(['success'=>'Position successfull updated !']);
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
        $designation = Designation::find($id);
        $designation->delete();
        return redirect()->route('designation.index')->with(['success'=>'Position successfull deleted !']);
    }
}
