<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;
use App\Documents;
use App\ContractEmployee;
use App\Http\Controllers\karyawan\AccountController;
use Illuminate\Support\Facades\Storage;

class DocumentsController extends Controller
{
    protected $accountContrller;
    public function __construct(AccountController $accountContrller)
    {
        $this->accountContrller = $accountContrller;

    }
    public function index(){
        $initial = $this->accountContrller->getinitialname(Auth::guard("emp")->user()->name);
        return view('karyawan.account.files.index',compact('initial'));
    }
    

    public function documentsAjax(request $request){
        $column = array("name","documents","actions");
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $temp  = DB::table('documents')->select('id','name','documents','id as actions')
                    ->where('employee_id',Auth::guard("emp")->user()->id);
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(name) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $edit='<a href="javascript:;" data-attr="'.route('emp.myfile.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus='<a  href="javascript:;" data-attr="'.route('emp.myfile.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show" title="Delete">
                            <i class="la flaticon-delete"></i>
                        </a>';
                if($row->documents != null){
                    $document ='<a href="'.asset("storage/documents/".$row->documents).'" target="_blank" class="btn btn-default  btn-icon-sm btn-sm">
                                    <i class="la la-download"></i>
                                    download 
                                </a>';
                }else{
                    $document = "-";
                }
                $obj['name']            = $row->name;
                $obj['documents']       = $document;
                $obj['actions']         = $edit.''.$hapus;
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

    public function create(){
        return view('karyawan.account.files.create');
    }

    public function store(request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'documents' => 'required|mimes:jpeg,png,pdf|max:700kb',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['danger'=>$validator->errors()->first()]);
        }else{
            if($request->hasFile('documents')){
                $filenameWithExt = $request->file('documents')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('documents')->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                $request->file('documents')->storeAs('public/documents',$fileNameToStore);
            }else{
                $fileNameToStore = "No";
            }
            $documents              = new Documents;
            $documents->employee_id = Auth::guard("emp")->user()->id;
            $documents->name        = $request->name;
            $documents->documents = $fileNameToStore;
            $documents->save();
            return redirect()->back()->with(['success'=>'Your Documents Successfull Created !']);
        }
    }

    public function edit($id){
        $documents   = Documents::find($id);
        return view('karyawan.account.files.edit',compact("documents"));
    }

    public function update(request $request, $id){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            // 'documents'=>'required'
            'documents' => 'required|mimes:jpeg,png|size:700',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{

            $documents   = Documents::find($id);
            $path = '/public/documents/'.$documents->documents;
            Storage::delete($path);
            if(!Storage::exists($path)){
                if($request->hasFile('documents')){
                    $filenameWithExt = $request->file('documents')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('certificate')->getClientOriginalExtension();
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;
                    $path = $request->file('documents')->storeAs('public/documents',$fileNameToStore);
                }else{
                    $fileNameToStore = "No";
                }
                $documents                  = Documents::find($id);
                $documents->employee_id     = Auth::guard("emp")->user()->id;
                $documents->name            = $request->name;
                $documents->documentsAjax   = $fileNameToStore;
                $documents->save();
                return redirect()->back()->with(['success'=>'Your Documents Successfull Created !']);
            }
        }
    }

    public function show($id){
        $documents   = Documents::find($id);
        return view('karyawan.account.files.show',compact("documents"));
    }

    public function delete($id){
        $documents   = Documents::find($id);
        $path = '/public/documents/'.$documents->documents;
        Storage::delete($path);
        if(!Storage::exists($path)){
            $documents->delete();
        }
        return redirect()->back()->with(['success'=>'Your Documents Successfull Deleted !']);
    }

    public function contract(){
        $initial = $this->accountContrller->getinitialname(Auth::guard("emp")->user()->name);
        return view('karyawan.account.contract.index',compact('initial'));
    }
    
    public function contractAjax(request $request){
        $column = array("start_date","end_date","contract","actions");
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $temp  = DB::table('contract_employee')->select('id','start_date','end_date','contract','id as actions')
                    ->where('employee_id',Auth::guard("emp")->user()->id);
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(start_date) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $edit='<a href="javascript:;" data-attr="'.route('emp.contract.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-contract" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus='<a  href="javascript:;" data-attr="'.route('emp.contract.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-contract" title="Delete">
                            <i class="la flaticon-delete"></i>
                        </a>';
                if($row->contract != null){
                    $contract ='<a href="'.asset("storage/contract/".$row->contract).'" target="_blank" class="btn btn-default  btn-icon-sm btn-sm">
                                    <i class="la la-download"></i>
                                    download 
                                </a>';
                }else{
                    $contract = "-";
                }
                $obj['start_date']     = date("d M Y",strtotime($row->start_date));
                $obj['end_date']       = date("d M Y",strtotime($row->end_date));
                $obj['contract']       = $contract;
                $obj['actions']        = $edit.''.$hapus;
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

    public function createContract($id){
        return view('karyawan.account.contract.create');
    }

    public function storeContract(request $request, $id){

        $validator = Validator::make($request->all(),[
            'start_date'=>'required',
            'end_date'=>'required',
            'contract' => 'required|mimes:jpeg,png,pdf|max:700kb',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['danger'=>$validator->errors()->first()]);
        }else{
            if($request->hasFile('contract')){
                $filenameWithExt = $request->file('contract')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('contract')->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                $request->file('contract')->storeAs('public/contract',$fileNameToStore);
            }else{
                $fileNameToStore = "No";
            }
            $contract              = new ContractEmployee;
            $contract->employee_id = Auth::guard("emp")->user()->id;
            $contract->start_date  = date("Y-m-d",strtotime($request->start_date));
            $contract->end_date    = date("Y-m-d",strtotime($request->end_date));
            $contract->contract   = $fileNameToStore;
            $contract->save();
            return redirect()->back()->with(['success'=>'Your Documents Successfull Created !']);
        }
    }

    public function editContract($id){
        $contract    = ContractEmployee ::find($id);
        return view('karyawan.account.contract.edit',compact("contract"));
    }

    public function updateContract(request $request, $id){

        $validator = Validator::make($request->all(),[
            'start_date'=>'required',
            'end_date'=>'required',
            // 'documents' => 'required|mimes:jpeg,png|size:700',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['danger'=>$validator->errors()->first()]);
        }else{

            $contract   = ContractEmployee::find($id);
            $path = '/public/contract/'.$contract->contract;
            Storage::delete($path);
            if(!Storage::exists($path)){
                if($request->hasFile('contract')){
                    $filenameWithExt = $request->file('contract')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('contract')->getClientOriginalExtension();
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;
                    $path = $request->file('contract')->storeAs('public/contract',$fileNameToStore);
                }else{
                    $fileNameToStore = $contract->contract;
                }
                $contract              = ContractEmployee::find($id);
                $contract->start_date  = date("Y-m-d",strtotime($request->start_date));
                $contract->end_date    = date("Y-m-d",strtotime($request->end_date));
                $contract->contract   = $fileNameToStore;
                $contract->save();
                return redirect()->back()->with(['success'=>'Your Documents Successfull Created !']);
            }
        }
    }

    public function showContract($id){
        $contract   = ContractEmployee::find($id);
        return view('karyawan.account.contract.show',compact("contract"));
    }
    
    public function deleteContract($id){
        $contract   = ContractEmployee::find($id);
        $path = '/public/contract/'.$contract->contract;
        Storage::delete($path);
        if(!Storage::exists($path)){
            $contract->delete();
        }
        return redirect()->back()->with(['success'=>'Your Documents Successfull Deleted !']);
    }





}
