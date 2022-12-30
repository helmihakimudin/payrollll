<?php

namespace App\Http\Controllers\Admin;

use App\Contract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.contract.index");
    }

    public function getContract(request $request){
        $column = array('contract_name','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $temp  = Contract::select('id','contract_name','id as actions');
       
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(contract_name) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $edit  ="-";
                $hapus ="-";
                if(Auth::user()->can('Edit Kontrak')){
                    $edit   ='<a href="javascript:;" data-attr="'.route('contract.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit" title="Edit">
                                <i class="la flaticon-edit"></i>
                            </a>';
                }
                if(Auth::user()->can('Hapus Kontrak')){
                    $hapus  ='<a href="javascript:;" data-attr="'.route('contract.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show" title="Edit">
                                <i class="la flaticon-delete"></i>
                              </a>';
                }
                $obj['contract_name'] = $row->contract_name;
                $obj['actions']       = $edit.''.$hapus;
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.contract.create');
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
            'contract_name' =>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
                $contract = new Contract;
                $contract->contract_name = $request->contract_name;
                $contract->save();
            return redirect()->route('contract.index')->with(['success'=>'Contract Successfull Created !']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contract  $Contract
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contract = Contract::find($id);
        return view('admin.contract.show',compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contract  $Contract
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contract = Contract::find($id);
        return view('admin.contract.edit',compact('contract'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract  $Contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'contract_name' =>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $contract = Contract::find($id);
            $contract->contract_name = $request->contract_name;
            $contract->save();
            return redirect()->route('contract.index')->with(['success'=>'Contract Successfull Updated !']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contract  $Contract
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $contract = Contract::find($id);
        $contract->delete();
        return redirect()->route('contract.index')->with(['success'=>'Contract Successfull Deleted!']);
    }
}
