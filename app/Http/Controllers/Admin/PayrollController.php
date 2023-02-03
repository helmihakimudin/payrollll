<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;
use App\Employee;
use App\PayrollComponent;
use App\Payslip;
use App\Component;
use App\ComponentUsed;
use Maatwebsite\Excel\Facades\Excel;
use App\PayrollEmployeeComponent;
use App\Exports\ExportComponenPayroll;
use App\Exports\ExportEditComponenPayroll;
use App\Imports\ImportComponentPayroll;
use App\TempEmpComponent;
use App\JobPosition;
use App\Joblevel;
use App\Branch;
use App\EmployeeThr;
use App\Organization;
use Mail;
use PDF;
use App\Mail\EmployeeEmail;
use Carbon\Carbon;



class PayrollController extends Controller
{
    public function index(){
        return view('admin.payroll.index');
    }

    public function showrunpayroll(){
        return view('admin.payroll.run-payroll.index');
    }

    public function continuepayroll(request $request){
        $year   = date("Y",strtotime($request->transaksi_id));
        $month  = date("m",strtotime($request->transaksi_id));
        $id = PayrollComponent::whereYear('effective_date', '=', $year)->whereMonth('effective_date', '=', $month)->orWhereYear('end_date','=', $year)->orWhereMonth('end_date','=', $month)->pluck('id')->first();

        $payrollemployeecomponent = PayrollEmployeeComponent::join('employees','payroll_employee_component.employee_id','employees.id')
                                    ->leftjoin('organization','employees.organization_id','organization.id')
                                    ->select('employees.id as employee_id','employees.full_name','payroll_employee_component.component','organization.name as organization','payroll_employee_component.is_created')
                                    ->where('payroll_employee_component.is_run','=', 0)
                                    ->get();

        return view('admin.payroll.run-payroll.continue-run-payroll',compact('payrollemployeecomponent'));
    }

    public function runpayroll(request $request){
        $employee_id  = $request->employee_id;
        if($employee_id != null){
            $payrollcomponent = PayrollEmployeeComponent::join('employees','payroll_employee_component.employee_id','=','employees.id')
                        ->select('employees.basic_salary','payroll_employee_component.component','payroll_employee_component.employee_id','payroll_employee_component.id','payroll_employee_component.is_created')
                        ->whereIN('payroll_employee_component.employee_id',$employee_id)
                        ->get();
            foreach($payrollcomponent as $row){
                $effectivedate =  PayrollComponent::find($row->is_created);
                // dd($effectivedate);
                $allowance = json_decode($row->component);
                $arr_allowance = array();
                $total_allowance = 0;
                foreach($allowance as $rows){
                    if($rows->type == "Allowance"){
                        $total_allowance += $rows->amount;
                        $arr_allowance [] = [
                            'component_id'=>$rows->component_id,
                            'component'=>$rows->component,
                            'type'=>$rows->type,
                            'amount'=>$rows->amount
                        ];
                    }
                }
                $deduction = json_decode($row->component);
                $arr_deduction = array();
                $total_deduction = 0;
                foreach($deduction as $rows){
                    if($rows->type == "Deduction"){
                        $total_deduction += $rows->amount;
                        $arr_deduction [] = [
                            'component_id'=>$rows->component_id,
                            'component'=>$rows->component,
                            'type'=>$rows->type,
                            'amount'=>$rows->amount
                        ];
                    }
                }
                $employee = Employee::find($row->employee_id);
                $takehomepay = $total_allowance - $total_deduction;
                if($employee->is_bpjs_active == 'Active'){
                    $is_bpjs_active = 1;
                }else{
                    $is_bpjs_active = 0;
                }
                $payslip = new Payslip;
                $payslip->employee_id           = $row->employee_id;
                $payslip->salary_month          = date('Y-m',strtotime($effectivedate->end_date));
                $payslip->basic_salary          = $row->basic_salary;
                $payslip->net_payble            = $takehomepay;
                $payslip->is_bpjs_active        = $is_bpjs_active;
                $payslip->status                = 0;
                $payslip->allowance             = json_encode($arr_allowance);
                $payslip->deduction             = json_encode($arr_deduction);
                $payslip->created_by            = Auth::user()->name;
                $payslip->save();
                $payrollcomponent = PayrollEmployeeComponent::whereIN('employee_id',$employee_id)->update([
                    'is_run'=>1,
                ]);

            }
            return redirect()->route('payroll')->with(['success'=>'Success Run Payroll']);
        }else{
            return redirect()->back()->with(['danger'=>'Please checklist employee befor Run Payroll']);
        }
    }

    /* Setting Payroll */
    public function component(){
        $getallowances  = Component::select('id','name','id as actions')->where('type','Allowance')->get();
        $getdeductions  = Component::select('id','name','id as actions')->where('type','Deduction')->get();
        $benefit        = Component::select('id','name','id as actions')->where('type','Benefit')->get();
        return view('admin.payroll.settings.index',compact('getallowances','getdeductions','benefit'));
    }

    public function createComponentAllow(){
        return view("admin.payroll.settings.allowance.create");
    }

    public function createComponentDeduction(){
        return view("admin.payroll.settings.deductions.create");
    }

    public function createComponentBenefit(){
        return view("admin.payroll.settings.benefit.create");
    }

    public function storeComponent(request $request){
        $validator = Validator::make($request->all(),[
            'name' =>'required',
            'type' =>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['danger'=>$validator->errors()->first()]);
        }else{
            $component = new Component;
            $component->name = $request->name;
            $component->type = $request->type;
            $component->save();
            return redirect()->back()->with(['success'=>'component Successfull Created !']);
        }
    }

    public function editComponentAllowance($id) {
        $component = Component::find($id);
        return view("admin.payroll.settings.allowance.edit",compact('component'));
    }

    public function editComponentDeductions($id) {
        $component = Component::find($id);
        return view("admin.payroll.settings.deductions.edit",compact('component'));
    }

    public function editComponentBenefit($id) {
        $component = Component::find($id);
        return view("admin.payroll.settings.benefit.edit",compact('component'));
    }

    public function updateComponent(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'name' =>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['danger'=>$validator->errors()->first()]);
        }else{
            $component = Component::find($id);
            $component->name = $request->name;
            $component->save();
            return redirect()->back()->with(['success'=>'component Successfull updated !']);
        }
    }

    public function showComponentAllow($id) {
        $component = Component::find($id);
        return view("admin.payroll.settings.allowance.show",compact('component'));
    }

    public function showComponentDeduction($id) {
        $component = Component::find($id);
        return view("admin.payroll.settings.deductions.show",compact('component'));
    }

    public function showComponentBenefit($id) {
        $component = Component::find($id);
        return view("admin.payroll.settings.benefit.show",compact('component'));
    }

    public function deleteComponent($id){
        $component = Component::find($id);
        $component->delete();
        return redirect()->back()->with(['success'=>'component Successfull Deleted !']);
    }

    /* End Setting Payroll */


    /* begin component payroll */
    public function componentindex(){
        return view('admin.payroll.component.index');
    }

    public function componentpayroll(request $request){
        $column = array('transaksi_id','type_adjustment','effective_date','end_date','created_by','description','employees','component','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = PayrollComponent::select('id','transaksi_id','type_adjustment','effective_date','end_date','created_by','description','employees','component','id as actions')->orderBy('id','DESC');
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(transaksi_id) LIKE '%".$search."%' OR LOWER(type_adjustment) LIKE '%".$search."%' OR LOWER(effective_date) LIKE '%".$search."%' OR LOWER(created_by) LIKE '%".$search."%' OR LOWER(description) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                $edit  ="-";
                $hapus = "-";

                $edit='<a href="'.route('payroll.component.edit',$row->id).'"  class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                            <i class="la la-eye"></i>
                        </a>';
                if($row->employees == 0){
                    $deleted='<a href="'.route('payroll.component.delete',$row->id).'"   class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                        <i class="la la-trash"></i>
                    </a>';
                }else{
                    $deleted="";
                }
                $obj['transaksi_id']    = $row->transaksi_id;
                $obj['type_adjustment'] = $row->type_adjustment;
                $obj['effective_date']  = date("d M Y",strtotime($row->effective_date));
                if($row->end_date =="-" ||$row->end_date =="1970-01-01"){
                    $obj['end_date']        = "-";
                }else{
                    $obj['end_date']        = date("d M Y",strtotime($row->end_date));
                }
                $obj['created_by']      = $row->created_by;
                $obj['description']     = $row->description;
                $obj['employees']       = $row->employees." Employees";
                $obj['component']       = 'Basic Salary + '.'<a href="javascript:;">'.$row->component.' Others </a>';
                $obj['actions']         = $edit." ".$deleted;
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

    public function upcomponent(){
        $employee =  DB::table('payroll_employee_component')
                    ->join('employees','payroll_employee_component.employee_id','=','employees.id')
                    ->select('payroll_employee_component.id','payroll_employee_component.component','employees.id as emp_id','employees.employee_id','employees.full_name')
                    ->where('payroll_employee_component.is_created',0)
                    ->get();

        return view('admin.payroll.component.update-component',compact('employee'));
    }

    public function searchEmployeeComponent(request $request){

        $employee =  DB::table('payroll_employee_component')
                    ->leftjoin('employees','payroll_employee_component.employee_id','=','employees.id')
                    ->select('payroll_employee_component.id','employees.id as emp_id','employees.employee_id','employees.full_name','payroll_employee_component.component')
                    ->whereRaw("(LOWER(employees.full_name) LIKE '%".$request->searchemployee."%')")
                    ->where('payroll_employee_component.is_created',0)
                    ->get();
        return view('admin.payroll.component.update-component',compact('employee'));
    }

    public function add_employee(){
        $jobposition    = JobPosition::all();
        $joblevel       = Joblevel::all();
        $branch         = Branch::all();
        $organization   = Organization::all();
        return view('admin.payroll.component.create',compact('jobposition','joblevel','branch','organization'));
    }

    public function add_component(request $request){

        return view('admin.payroll.component.create-component');
    }

    public function getemployeeajax(request $request){
        $employee = Employee::join('organization','employees.organization_id','=','organization.id')
                    ->select('employees.full_name','organization.name','employees.id')
                    ->where('employees.organization_id',$request->getvalue)
                    ->orWhereRaw("(LOWER(employees.full_name) LIKE '%".$request->getvalue."%')")
                    ->get();
        return response()->json($employee);
    }

    public function storeEmployee(request $request){
        $count = $request->employee_id;
        $arr  = array();
        for($i=0; $i <count($count); $i++){
            $arr [] = [
                'employee_id'=>$count[$i],
            ];
        }

        DB::table('payroll_employee_component')->insert($arr);
        return redirect()->back()->with(['success'=>'Employee has been updated !']);
    }

    public function deletedEmployee(request $request){
        $count = $request->employee_id;
        DB::table('payroll_employee_component')->whereIn('employee_id',$count)->delete();
        return redirect()->back()->with(['success'=>'Employee has been Deleted !']);
    }

    public function getcomponentajax(request $request){
        if($request->getvalue != null){
            $component  = DB::table('component')->orWhereRaw("(LOWER(component.name) LIKE '%".$request->getvalue."%')");
        }else{
            $component  = DB::table('component');
        }
            $temp = $component->get();
        return response()->json($temp);
    }

    public function getcomponentfilter(request $request){
        $count = $request->getvaluecomponent;
        $component  = DB::table('component')->select('id','name','type')->whereIN('id',$count)->get();
        return response()->json($component);
    }

    public function catchcomponent(request $request){
        $count = $request->getcomponent;
        $arr  = array();


        for($i=0; $i <count($count); $i++){
            $components = Component::find($count[$i]);
            $arr [] = [
                'component_id'   =>$count[$i],
                'component'      =>$components->name,
                'type'           =>$components->type,
                'amount'         =>0
            ];
        }
        $payrollcomponent = PayrollEmployeeComponent::where('is_created',0)->get();
        foreach($payrollcomponent as $row){
            DB::table('payroll_employee_component')->where('employee_id',$row->employee_id)->update([
                'component'=>json_encode($arr)
            ]);
        }
        return redirect()->back()->with(['success'=>'component has been updated !']);
    }

    public function exportcomponent(){
        return Excel::download(new ExportComponenPayroll, 'emm-component.xlsx');
    }

    public function showimportcomponent(){
        return view('admin.payroll.component.show-modal-import');
    }

    public function importcomponent(request $request){

        $validator = Validator::make($request->all(),[
            'import' => 'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['danger'=>'file  not yet import!']);
        }else{
            $file = $request->file('import');
            $nama_file = $file->getClientOriginalName();
            $file->move(public_path('/import'),$nama_file);
            $arrays = (new ImportComponentPayroll)->toArray(public_path('/import/'.$nama_file));
            $payrollcomponent = PayrollEmployeeComponent::where('is_created',0)->get();
            foreach($payrollcomponent as $key => $temp){
                $arr = array();
                foreach($arrays[0] as $row){
                    if($temp->employee_id == $row['user_id']){
                        array_push($arr,[
                            "component_id" => $row['component_id'],
                            "component" => $row['component'],
                            "type" =>  $row['type'],
                            "amount" =>  $row['amount'],
                        ]);
                    }
                }
                $component = json_encode($arr);
                $payrollcomponent = PayrollEmployeeComponent::where('is_created',0)->where('employee_id',$temp->employee_id)->update([
                    'component'=>$component
                ]);
            }
            return redirect()->back();
        }
    }

    public function storecomponents(request $request){
        $validator = Validator::make($request->all(),[
            'type_adjustment' => 'required',
            'effective_date' => 'required',
            'description'   =>'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['danger'=>$validator->errors()->first()]);
        }else{
            $payrollcomponent = PayrollEmployeeComponent::where('is_created','=',0);
            $getcomponent     =  $payrollcomponent->get();
            $countemployee    =  $payrollcomponent->where('is_created','=',0)->count();
            if(is_array($getcomponent)){
                foreach($getcomponent as $row){
                    $counts = json_decode($row->component);
                    $count = count($counts);
                }
            }else{
                $count=0;
            }

            $payrollcomponent = new PayrollComponent;
            $payrollcomponent->transaksi_id = date('dmy')."".rand(10,1000);
            $payrollcomponent->description = $request->description;
            $payrollcomponent->type_adjustment = $request->type_adjustment;
            $payrollcomponent->effective_date = Carbon::createFromFormat('d/m/Y', $request->effective_date)->format("Y-m-d");
            if($request->end_date != null){
                $payrollcomponent->end_date = Carbon::createFromFormat('d/m/Y', $request->end_date)->format("Y-m-d");
            }else{
                $payrollcomponent->end_date = "-";
            }
            $payrollcomponent->created_by = Auth::user()->name;
            $payrollcomponent->employees = $countemployee;
            $payrollcomponent->component = $count;
            $payrollcomponent->save();

            foreach($getcomponent as $row){
                $payrolltempcomponent = PayrollEmployeeComponent::find($row->id);
                $payrolltempcomponent->is_created = $payrollcomponent->id;
                $payrolltempcomponent->save();
            }
            return redirect()->route('payroll.component')->with(['success'=>'Payroll component success created!']);
        }
    }

    public function editComponent($id){
        $payrollcomponent =  PayrollComponent::find($id);
        $payrollEmployeetempcomponent = PayrollEmployeeComponent::join('employees','payroll_employee_component.employee_id','=','employees.id')
        ->select('payroll_employee_component.id','payroll_employee_component.component','employees.id as emp_id','employees.employee_id','employees.full_name')
        ->where('payroll_employee_component.is_created',$payrollcomponent->id)
        ->get();
        return view('admin.payroll.component.edit-component',compact('payrollcomponent','payrollEmployeetempcomponent'));
    }

    public function searchEmployeeComponentEdit(request $request, $id){
        $payrollcomponent =  PayrollComponent::find($id);
        $payrollEmployeetempcomponent =  DB::table('payroll_employee_component')
                    ->leftjoin('employees','payroll_employee_component.employee_id','=','employees.id')
                    ->select('payroll_employee_component.id','employees.id as emp_id','employees.employee_id','employees.full_name','payroll_employee_component.component')
                    ->whereRaw("(LOWER(employees.full_name) LIKE '%".$request->searchemployee."%')")
                    ->where('payroll_employee_component.is_created',$payrollcomponent->id)
                    ->get();
        // dd($payrollEmployeetempcomponent);
        return view('admin.payroll.component.edit-component',compact('payrollcomponent','payrollEmployeetempcomponent'));
    }

    public function edit_employee($id){
        $payrollcomponent_id = $id;
        $organization   = Organization::all();
        return view('admin.payroll.component.edit.employee',compact('organization','payrollcomponent_id'));
    }

    public function editComponentEmployeeStore(request $request, $id){
        $count = $request->employee_id;
        $arr  = array();
        for($i=0; $i <count($count); $i++){
            $arr [] = [
                'is_created'=>$id,
                'employee_id'=>$count[$i],
            ];
        }
        foreach($arr as $row){
            $check = PayrollEmployeeComponent::where('is_created',$row['is_created'])->where('employee_id',$row['employee_id'])->exists();
            if($check){
                return redirect()->back()->with(['danger'=>'Employee checked has already in list !']);
            }else{
                DB::table('payroll_employee_component')->insert($arr);
            }
        }
        return redirect()->back()->with(['success'=>'Employee has been updated !']);
    }

    public function edit_component($id){
        $id = $id;
        return view('admin.payroll.component.edit.component',compact('id'));
    }

    public function editCatchComponent(request $request, $id){
        $count = $request->getcomponent;
        $arrgetcomponent = array();

        foreach($count as $c){
            $checkused = ComponentUsed::where('id',$c)->first();
            if(!$checkused){
                $componentUsed = new ComponentUsed;
                $componentUsed->id = $c;
                $componentUsed->save();
            }
        }

        $getAllComponentUseds = ComponentUsed::get();
        foreach($getAllComponentUseds as $getAllComponentUsed){
            array_push($arrgetcomponent,$getAllComponentUsed->id);
        }

        if($arrgetcomponent){
            $payrollcomponents = PayrollEmployeeComponent::get();
            foreach($payrollcomponents as $payrollcomponent){
                $arrcomp = array();
                $datas = [];
                if($payrollcomponent->component != null){
                    $datas = json_decode($payrollcomponent->component , true);
                    foreach($datas as $key => $v) {
                        foreach($datas[$key] as $k => $y){
                            if($k == 'component_id'){
                                array_push($arrcomp,$y);
                            }
                        }
                    }
                }

                $compare = array_diff($arrgetcomponent, $arrcomp);
                if($compare){
                    foreach($compare as $comp){
                        $components = Component::find($comp);
                        array_push($datas, [
                            'component_id'   =>$comp,
                            'component'      =>$components->name,
                            'type'           =>$components->type,
                            'amount'         =>0
                          ]);
                    }
                }
                $payrollcomponent->component = $datas;
                $payrollcomponent->save();
            }

        }

        return redirect()->back()->with(['success'=>'component has been updated !']);
    }

    public function editexportcomponent($id){
        return Excel::download(new ExportEditComponenPayroll($id), 'emm-component.xlsx');
    }

    public function showieditmportcomponent($id){
        $id = $id;
        return view('admin.payroll.component.edit.show-modal-import',compact('id'));
    }

    public function importeditcomponent(request $request, $id){

        $validator = Validator::make($request->all(),[
            'import' => 'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['danger'=>'file  not yet import!']);
        }else{
            $file = $request->file('import');
            $nama_file = $file->getClientOriginalName();
            $file->move(public_path('/import'),$nama_file);
            $arrays = (new ImportComponentPayroll)->toArray(public_path('/import/'.$nama_file));
            $payrollcomponent = PayrollEmployeeComponent::where('is_created',$id)->get();
            foreach($payrollcomponent as $key => $temp){
                $arr = array();
                foreach($arrays[0] as $row){
                    if($temp->employee_id == $row['user_id']){
                        array_push($arr,[
                            "component_id" => $row['component_id'],
                            "component" => $row['component'],
                            "type" =>  $row['type'],
                            "amount" =>  $row['amount'],
                        ]);
                    }
                }
                $component = json_encode($arr);
                $payrollcomponent = PayrollEmployeeComponent::where('is_created',$id)->where('employee_id',$temp->employee_id)->update([
                    'component'=>$component
                ]);
            }
            return redirect()->back();
        }
    }

    public function reupdateComponent(request $request, $id){
        $validator = Validator::make($request->all(),[
            'type_adjustment' => 'required',
            'effective_date' => 'required',
            'description'   =>'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['danger'=>$validator->errors()->first()]);
        }else{
            // dd($request->all());
            // dd($id);
            $payrollcomponent = PayrollEmployeeComponent::where('is_created','=',$id);
            $getcomponent     =  $payrollcomponent->get();
            $countemployee    =  $payrollcomponent->where('is_created','=',$id)->count();
            foreach($getcomponent as $row){
                $counts = json_decode($row->component);
                $count = count($counts);
            }
            $payrollcomponent = PayrollComponent::find($id);
            $payrollcomponent->transaksi_id = date('dmy')."".rand(10,1000);
            $payrollcomponent->description = $request->description;
            $payrollcomponent->type_adjustment = $request->type_adjustment;
            $payrollcomponent->effective_date = date('Y-m-d',strtotime($request->effective_date));
            if($request->end_date != null){
                $payrollcomponent->end_date = date('Y-m-d',strtotime($request->end_date));
            }else{
                $payrollcomponent->end_date = "-";
            }
            $payrollcomponent->created_by = Auth::user()->name;
            $payrollcomponent->employees = $countemployee;
            $payrollcomponent->component = $count;
            $payrollcomponent->save();

            foreach($getcomponent as $row){
                $arrComponents =json_decode($row->component);
                $i=0;
                foreach( $arrComponents as $component){
                    $arrComponents[$i]->amount=str_replace(".","",$request['component_amount'][$row->employee_id][$i]);
                    $i++;
                }

                $component = json_encode($arrComponents);
                PayrollEmployeeComponent::where('id',$row->id)->update(['employee_id'=>$row->employee_id,'component'=>$component]);
            }

            return redirect()->route('payroll.component')->with(['success'=>'Payroll component success created!']);
        }
    }


    public function edigetcomponentfilter(request $request){
        $count = $request->getvaluecomponent;
        $component  = DB::table('component')->select('id','name','type')->whereIN('id',$count)->get();
        return response()->json($component);
    }

    public function updatescomponents(request $request, $id){
        $TempEmpComponent =  TempEmpComponent::find($id);
        $TempEmpComponent->amount =  $request->amounts;

        $TempEmpComponent->save();
        return redirect()->route('payroll.component')->with(['success'=>'Amount component success Update!']);
    }

    public function deletecomponents($id){
        if($id){
            PayrollComponent::where('id',$id)->delete();

            return redirect()->back()->with(['success'=>'the component success deleted!']);
        }else{
            return redirect()->back()->with(['error'=>'the component cannot remove!']);
        }
    }
    /* end component payroll */


    /* Begin Payroll Report */
    public function payrollreport(){
        return view('admin.payroll.report.index');
    }

    public function payroll_salary_detail(request $request){
        $organization = $request->organization_id;
        $monthpicker  = $request->monthpicker;
        if($request->organization_id || $request->monthpicker){
            $payslip = Payslip::leftjoin('employees','pay_slips.employee_id','=','employees.id')
                ->leftjoin('organization','employees.organization_id','=','organization.id')
                ->select('employees.full_name','pay_slips.*','organization.name as organization')
                ->where('pay_slips.salary_month',$request->monthpicker)
                ->where('organization.id',$request->organization_id)
                ->get();
        }else{
            $payslip = Payslip::leftjoin('employees','pay_slips.employee_id','=','employees.id')
                ->leftjoin('organization','employees.organization_id','=','organization.id')
                ->select('employees.full_name','pay_slips.*','organization.name as organization')
                ->where('pay_slips.salary_month',date('Y-m'))
                ->get();
        }
        return view('admin.payroll.report.salary-type.index',compact('payslip','organization','monthpicker'));
    }

    public function payroll_salary_detail_show($id){
        $payslip = Payslip::leftjoin('employees','pay_slips.employee_id','=','employees.id')
                    ->leftjoin('organization','employees.organization_id','=','organization.id')
                    ->leftjoin('job_position','employees.job_position_id','=','job_position.id')
                    ->leftjoin('branches','employees.branch_id','=','branches.id')
                    ->select('employees.full_name','pay_slips.*','organization.name as organization','job_position.name as job_position','branches.name as branch')
                    ->where('pay_slips.id',$id)
                    ->first();
        return view('admin.payroll.report.salary-type.show',compact('payslip'));
    }

    public function payroll_report_salary_show($id){
        $salarytype = Payslip::find($id);
        return view('admin.payroll.report.salary-type.show-delete',compact('salarytype'));
    }

    public function payroll_report_salary_delete($id){
        $payslip = Payslip::find($id);
        $payslip->delete();
        return redirect()->back()->with(['success'=>'S success Delete!']);
    }

    public  function payroll_report_payslip(request $request){
        $organization = $request->organization_id;
        $monthpicker  = $request->monthpicker;
        if($request->organization_id || $request->monthpicker){
            $payslip = Payslip::join('employees','pay_slips.employee_id','=','employees.id')
                ->leftjoin('organization','employees.organization_id','=','organization.id')
                ->select('employees.full_name','pay_slips.*','organization.name as organization')
                ->where('pay_slips.salary_month',$request->monthpicker)
                ->where('organization.id',$request->organization_id)
                ->get();
        }else{
            $payslip = Payslip::join('employees','pay_slips.employee_id','=','employees.id')
                ->leftjoin('organization','employees.organization_id','=','organization.id')
                ->select('employees.full_name','pay_slips.*','organization.name as organization')
                ->where('pay_slips.salary_month',date('Y-m'))
                ->get();
        }
        return view('admin.payroll.report.payslip.index',compact('payslip','organization','monthpicker'));
    }

    public function payroll_report_payslip_detail($id){
        $payslip = Payslip::join('employees','pay_slips.employee_id','=','employees.id')
        ->leftjoin('organization','employees.organization_id','=','organization.id')
        ->leftjoin('job_position','employees.job_position_id','=','job_position.id')
        ->leftjoin('job_level','employees.job_level_id','=','job_level.id')
        ->leftjoin('branches','employees.branch_id','=','branches.id')
        ->select('employees.full_name','pay_slips.*','organization.name as organization','job_position.name as job_position',
                'job_level.name as job_level','branches.name as branch','employees.full_name','employees.ptkp_status',
                'employees.npwp','employees.basic_salary')
        ->where('pay_slips.id',$id)
        ->first();
        return view('admin.payroll.report.payslip.detail',compact('payslip'));
    }

    public function payroll_report_payslip_detail_pdf($id){
        $payslip = Payslip::join('employees','pay_slips.employee_id','=','employees.id')
        ->leftjoin('organization','employees.organization_id','=','organization.id')
        ->leftjoin('job_position','employees.job_position_id','=','job_position.id')
        ->leftjoin('job_level','employees.job_level_id','=','job_level.id')
        ->leftjoin('branches','employees.branch_id','=','branches.id')
        ->select('employees.full_name','pay_slips.*','organization.name as organization','job_position.name as job_position',
                'job_level.name as job_level','branches.name as branch','employees.full_name','employees.ptkp_status',
                'employees.npwp','employees.employee_id','employees.basic_salary')
        ->where('pay_slips.id',$id)
        ->first();
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => storage_path().'/app/public/pdf',
            'format' => 'A4-P',
            'margin_left'=>10,
            'margin_right'=>10,
            'margin_top'=>10,
            'margin_bottom'=>15,
            'margin_header'=>10,
        ]);
        $mpdf->SetTitle($payslip->full_name.' | '.date('F Y',strtotime($payslip->salary_month)));
        $mpdf->WriteHTML(view('admin.payroll.report.payslip.pdf',compact('payslip')));
        $mpdf->Output();
    }

    public function slipgajibyemail($id){
        $slipgaji = DB::table('pay_slips')->join('employees','pay_slips.employee_id','=','employees.id')
                    ->select('pay_slips.id','employees.full_name','employees.email','pay_slips.salary_month')
                    ->where('pay_slips.id',$id)->first();


        $komisidates="";
        $comissionmonths = date('m',strtotime($slipgaji->salary_month));
        if($comissionmonths == "01"){
            $komisidates  = "Januari";
        }else if($comissionmonths == "02"){
            $komisidates = "Februari";
        }else if($comissionmonths == "03"){
            $komisidates  = "Maret";
        }else if($comissionmonths == "04"){
            $komisidates = "April";
        }else if($comissionmonths == "05"){
            $komisidates = "Mei";
        }else if($comissionmonths == "06"){
            $komisidates = "Juni";
        }else if($comissionmonths == "07"){
            $komisidates = "July";
        }else if($comissionmonths == "08"){
            $komisidates = "Agustus";
        }else if($comissionmonths == "09"){
            $komisidates = "September";
        }else if($comissionmonths == "10"){
            $komisidates = "Oktober";
        }else if($comissionmonths == "11"){
            $komisidates = "November";
        }else if($comissionmonths == "12"){
            $komisidates = "Desember";
        }


        $data["email"]          = $slipgaji->email;
        $data["id"]             = $slipgaji->id;
        $data["client_name"]    = $slipgaji->full_name;
        $data["bulan"]          = $komisidates." ".date('Y',strtotime($slipgaji->salary_month));
        $data["subject"]        = "Slip Gaji ".$slipgaji->salary_month;
        $data["catatan"]        = "Payslip Bulan ini";

        $pdf = PDF::loadView('admin.payroll.report.payslip.export-pdf-via-email', $data);
        try{
            Mail::send('admin.payroll.report.payslip.sliptest', $data, function($message)use($data,$pdf) {
            $message->to($data["email"], $data["client_name"])
            ->subject($data["subject"])
            ->attachData($pdf->output(), "slipgaji-payroll-dss.pdf");
            });
        }catch(JWTException $exception){
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
             $this->statusdesc  =   "Error sending mail";
             $this->statuscode  =   "0";

        }else{

           $this->statusdesc  =   "Message sent Succesfully";
           $this->statuscode  =   "1";
        }
        $updateslip = Payslip::find($id);
        $updateslip->slipbyemail =1;
        $updateslip->save();

        return redirect()->back();
    }


    public function slipgajibyemailall(request $request){
        $checkboxid = $request->checkboxid;

        $payslip = Payslip::whereIn('pay_slips.id',$checkboxid)
        ->join('employees','pay_slips.employee_id','=','employees.id')
        ->select('pay_slips.id','employees.full_name','employees.email','pay_slips.salary_month')
        ->get();
        foreach($payslip as $row){
            $komisidates="";
            $comissionmonths = date('m',strtotime($row->salary_month));
            if($comissionmonths == "01"){
                $komisidates  = "Januari";
            }else if($comissionmonths == "02"){
                $komisidates = "Februari";
            }else if($comissionmonths == "03"){
                $komisidates  = "Maret";
            }else if($comissionmonths == "04"){
                $komisidates = "April";
            }else if($comissionmonths == "05"){
                $komisidates = "Mei";
            }else if($comissionmonths == "06"){
                $komisidates = "Juni";
            }else if($comissionmonths == "07"){
                $komisidates = "July";
            }else if($comissionmonths == "08"){
                $komisidates = "Agustus";
            }else if($comissionmonths == "09"){
                $komisidates = "September";
            }else if($comissionmonths == "10"){
                $komisidates = "Oktober";
            }else if($comissionmonths == "11"){
                $komisidates = "November";
            }else if($comissionmonths == "12"){
                $komisidates = "Desember";
            }


            $data["email"]          = $row->email;
            $data["id"]             = $row->id;
            $data["client_name"]    = $row->full_name;
            $data["bulan"]          = $komisidates." ".date('Y',strtotime($row->salary_month));
            $data["subject"]        = "Slip Gaji ".$row->salary_month;
            $data["catatan"]        = "Payslip Bulan ini";

            $pdf = PDF::loadView('admin.payroll.report.payslip.export-pdf-via-email',$data);

            try{
                Mail::send('admin.payroll.report.payslip.sliptest', $data, function($message)use($data,$pdf) {
                $message->to($data["email"], $data["client_name"])
                ->subject($data["subject"])
                ->attachData($pdf->output(), "slipgaji-payroll-dss.pdf");
                });
            }catch(JWTException $exception){
                $this->serverstatuscode = "0";
                $this->serverstatusdes = $exception->getMessage();
            }
            if (Mail::failures()) {
                 $this->statusdesc  =   "Error sending mail";
                 $this->statuscode  =   "0";

            }else{

               $this->statusdesc  =   "Message sent Succesfully";
               $this->statuscode  =   "1";
            }
            $updateslip = Payslip::find($row->id);
            $updateslip->slipbyemail =1;
            $updateslip->save();


        }
        return redirect()->back();
    }

    public function payroll_report_payslip_show($id){
        $payslip = Payslip::find($id);
        return view('admin.payroll.report.payslip.show',compact('payslip'));
    }

    public function payroll_report_payslip_delete($id){
        $payslip = Payslip::find($id);
        $payslip->delete();
        return redirect()->back()->with(['success'=>'Payslip success Delete!']);
    }

    /* End Payroll Report */

    /* Begin Run THR */
    public function showThr(){
        $employees = Employee::with(['organization','branch'])->get();
        return view('admin.payroll.run-thr.index', compact('employees'));
    }

    public function runThr(Request $request){

        if(!empty($request->all())){

            foreach($request->all() as $employee_id){
                $join_date = Employee::where('id',$employee_id)->pluck('join_date')->first();
                if(isset($join_date)){
                    $from = Carbon::createFromFormat('Y-m-d', $join_date);
                    $to = Carbon::createFromFormat('Y-m-d', Carbon::now()->format('Y-m-d'))->addMonth();
                    $employeeActiveMonths = $to->diffInMonths($from);

                    //get basic salary
                    $objComponent = PayrollEmployeeComponent::where('employee_id', $employee_id)->pluck('component')->first();
                    $arrComponent = json_decode($objComponent);
                    $basic_salary = $arrComponent[0]->amount;

                    if($employeeActiveMonths < 12){
                    $amountThr = (($employeeActiveMonths/12)*$basic_salary);
                    }else{
                    $amountThr = $basic_salary;
                    }

                    // run thr create table employee thr;
                    $data = array('employee_id'=> $employee_id,'total_months'=>$employeeActiveMonths,'amount_thr'=> $amountThr,'is_run'=> 1);
                    EmployeeThr::create($data);
                }
                else{
                    $data = ['message' => 'error','redirect_url'=> route('payroll.run.thr')];
                    return response()->json($data, 404);
                }
            }

            $data = ['message' => 'success','redirect_url'=> route('payroll')];
            return response()->json($data, 200);
        }
    }

    /* End Run THR */
}
