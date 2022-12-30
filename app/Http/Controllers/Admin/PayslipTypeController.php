<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PayslipType;
use Illuminate\Http\Request;
use Validator;
use Auth;

class PayslipTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.payslip-type.index");
    }

    public function getPayslipType(request $request){
        $column = array('name','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $temp  = PayslipType::select('id','name','id as actions');
       
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
                $edit = "-";
                $hapus = "-";
                if(Auth::user()->can('Edit Jenis Gaji')){
                    $edit = '<a href="javascript:;" data-attr="'.route('payslip-type.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit" title="Edit">
                                <i class="la flaticon-edit"></i>
                            </a>';
                }
                if(Auth::user()->can('Hapus Jenis Gaji')){
                    $hapus='<a href="javascript:;" data-attr="'.route('payslip-type.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show" title="Edit">
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
        return view('admin.payslip-type.create');
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
     
                $paysliptype = new PayslipType;
                $paysliptype->name = $request->name;
                $paysliptype->created_by = $request->created_by;
                $paysliptype->save();
            return redirect()->route('payslip-type.index')->with(['success'=>'Payslip Type Successfull Created !']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PayslipType  $payslipType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paysliptype = PayslipType::find($id);
        return view('admin.payslip-type.show',compact('paysliptype'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PayslipType  $payslipType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paysliptype = PayslipType::find($id);
        return view('admin.payslip-type.edit',compact('paysliptype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PayslipType  $payslipType
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
            $paysliptype = PayslipType::find($id);
            $paysliptype->name = $request->name;
            $paysliptype->created_by = $request->created_by;
            $paysliptype->save();
            return redirect()->route('payslip-type.index')->with(['success'=>'Payslip Type Successfull Updated !']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PayslipType  $payslipType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paysliptype = PayslipType::find($id);
        $paysliptype->delete();
        return redirect()->route('payslip-type.index')->with(['success'=>'Payslip Type Successfull Deleted!']);
    }
}
