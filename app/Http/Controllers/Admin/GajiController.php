<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use App\Exports\ExportGaji;
use App\Imports\ImportGaji;
use App\Designation;
use App\Branch;
use App\Allowance;
use App\SaturationDeduction;
use App\Department;
use App\PayslipType;
use App\AllowanceOption;
use App\DeductionOption;
use App\JobPosition;
use App\Kasbon;
use App\Employee;
use App\ImportPayroll;
use App\Component;
use App\PayrollComponent;
use App\PayrollEmployeeComponent;
use Carbon\Carbon;

class GajiController extends Controller
{
    public function index(){
        return view("admin.gajikaryawan.index");
    }

    public function karyawanAjax(request $request){
        $column = array('full_name','email','salary_type','basic_salary','net_salary','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = Employee::join('payroll_employee_component','employees.id',"=","payroll_employee_component.employee_id")
        ->select('employees.id','employees.full_name','employees.email','employees.salary_type','employees.basic_salary','employees.id as actions','payroll_employee_component.component');
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw(" salary_type = 'Monthly' AND (LOWER(employees.full_name) LIKE '%".$search."%' OR LOWER(employees.email) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                $components = json_decode($row->component,true);
                $edit  ="-";
                $hapus = "-";
                if(Auth::user()->can('Edit Gaji')){
                    $edit='<a href="'.route('gaji.edit',['id' => $row->id]).'"  class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                                <i class="la la-eye"></i>
                            </a>';
                }
                if(Auth::user()->can('Hapus Gaji')){

                }
                $obj['name']            = $row->full_name;
                $obj['email']           = $row->email;
                $obj['salary_type']     = $row->salary_type;
                $obj['salary']          = "Rp.".number_format($components[0]['amount'],2,',','.');
                $obj['net_salary']      = "Rp.".number_format($components[1]['amount'],2,',','.');
                $obj['actions']         = $edit;
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

    public function gajiAjaxTunjangan(request $request){
        $column = array('name','allowance_type','amount','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $employee_id = $request->employee_id;
        $temp  = Allowance::leftjoin('allowance_options','allowances.allowance_option','=','allowance_options.id')
                ->select('allowance_options.name','allowances.id','allowances.amount','allowances.id as actions')
                ->where('allowances.employee_id',$employee_id)
                ->where('allowances.month',$request->month);

        $total = $temp->count();
        $totalFiltered = $total;

        if(empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(allowance_options.name) LIKE '%".$search."%' OR LOWER(allowances.amount) LIKE '%".$search."%')")

              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key =>  $row) {
                $edit="-";
                $hapus = "-";
                if(Auth::user()->can('Edit Pendapatan Karyawan')){
                    $edit='<button type="button" data-id="'.$row->id.'" onclick="edittunjangan(this)" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                             <i class="la flaticon-edit"></i>
                          </button>';
                }
                if(Auth::user()->can('Hapus Pendapatan Karyawan')){
                    $hapus='<a href="'.route('gaji.tunjangan.destroy',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                <i class="la flaticon-delete"></i>
                            </a>';
                }
                $obj['name']            = $row->name;
                $obj['amount']          = "Rp.".number_format($row->amount,2,',','.');
                $obj['actions']         = $edit.''.$hapus;
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

    public function gajiAjaxPengurangan(request $request){
        $column = array('name','allowance_type','amount','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $employee_id = $request->input('employee_id');
        $temp  = SaturationDeduction::leftjoin('deduction_options','saturation_deductions.deduction_option','=','deduction_options.id')
                ->select('saturation_deductions.amount','saturation_deductions.id','deduction_options.name','saturation_deductions.id as actions')
                ->where('saturation_deductions.employee_id',$employee_id)
                ->where('saturation_deductions.month',$request->month);

        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(deduction_options.name) LIKE '%".$search."%' OR LOWER(saturation_deductions.amount) LIKE '%".$search."%' OR LOWER(saturation_deductions.month) LIKE '%".$search."%')")
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
                if(Auth::user()->can('Edit Pemotongan Karyawan')){
                    $edit='<button type="button" data-id="'.$row->id.'" onclick="edit(this)" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                             <i class="la flaticon-edit"></i>
                          </button>';
                }
                if(Auth::user()->can('Hapus Pemotongan Karyawan')){
                    $hapus = '<a href="'.route('gaji.pengurangan.destroy',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                <i class="la flaticon-delete"></i>
                             </a>';
                }
                $obj['name']            = $row->name;
                $obj['amount']          = "Rp.".number_format($row->amount,2,',','.');
                $obj['actions']         = $edit.''.$hapus;
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

    public function create(){
        return view('admin.gajikaryawan.create');
    }


    public function store(request $request){
        $validator = Validator::make($request->all(),[
            'salary_type'=>'required',
            'salary'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            if($request->calculate_work != null){
                $id = $request->employee_id;
                $karyawan = Employee::find($id);
                $karyawan->salary_type      = $request->salary_type;
                $karyawan->salary           = $request->salary;
                $karyawan->calculate_work   = $request->calculate_work;
                $karyawan->amount_work      = $request->amount_work;
                $karyawan->net_salary       = $request->net_salary;
                $karyawan->save();
            }else{
                $id = $request->employee_id;
                $karyawan = Employee::find($id);
                $karyawan->salary_type      = $request->salary_type;
                $karyawan->salary           = $request->salary;
                $karyawan->calculate_work   = $request->amount_work;
                $karyawan->amount_work      = $request->amount_work;
                $karyawan->net_salary       = $request->salary;
                $karyawan->save();
            }

            return redirect()->back()->with(['success'=>'Gaji  Sukses Diubah !']);
        }
    }

    public function storetunjangan(request $request){
        $validator = Validator::make($request->all(),[
            'allowance_option'=>'required',
            'amount'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $allow = new Allowance;
            $allow->employee_id         = $request->employee_id;
            $allow->allowance_option    = $request->allowance_option;
            $allow->amount              = $request->amount;
            $allow->month               = date('Y-m');
            $allow->created_by          = Auth::user()->id;
            $allow->save();
            return redirect()->back()->with(['success'=>'Tunjangan berhasil dibuat!']);
        }
    }

    public function edittunjangan($id){
        $pengurangan = Allowance::join('allowance_options','allowances.allowance_option','=','allowance_options.id')
                    ->select('allowances.id','allowance_options.name','allowances.amount')
                    ->where('allowances.id',$id)
                    ->where('month',date('Y-m'))
                    ->first();
        return response()->json($pengurangan);
    }

    public function updatetunjangan(request $request){
        $validator = Validator::make($request->all(),[
            'amount'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $id = $request->id;
            $allow = Allowance::find($id);
            $allow->amount              = $request->amount;
            $allow->save();
            $cek =  DB::table('pay_slips')->where('employee_id',$allow->employee_id)->where('salary_month',$allow->month)->exists();
            if($cek){
                $payslips =  DB::table('pay_slips')->where('employee_id',$allow->employee_id)->where('salary_month',$allow->month)->update([
                    'net_payble' => Employee::updategajibersih($allow->month, $allow->employee_id),
                    'allowance' => Employee::updatetunjangan($allow->month, $allow->employee_id),
                    'slipbyemail'=>0
                ]);
            }

            return redirect()->back()->with(['success'=>'Tunjangan berhasil Diubah!']);
        }
    }

    public function potonganstore(request $request){
        $validator = Validator::make($request->all(),[
            'amount'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $allow = new Allowance;
            $allow->employee_id         = $request->employee_id;
            $allow->allowance_option    = 0;
            $allow->amount              = $request->amount;
            $allow->created_by          = Auth::user()->id;
            $allow->save();
            return redirect()->back()->with(['success'=>'Kasbon berhasil dibuat!']);
        }
    }


    public function storepengurangan(request $request){
        $validator = Validator::make($request->all(),[
            'deduction_option'=>'required',
            'amount'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $id = $request->employee_id;
            $deduction_option = DB::table('deduction_options')->where('id',$request->deduction_option)->first();

            if($deduction_option->name =='Kasbon'){

                $karyawan = Employee::where('id',$request->employee_id)->first();
                if($request->amount > $karyawan->amount_of_leave){
                    return redirect()->back()->with(['error'=>'Jumlah yang dimasukkan tidak sesuai.']);
                }
                $kasbonreduce = $karyawan->amount_of_leave - $request->amount;
                $karyawan = Employee::where('id',$request->employee_id)->update([
                    'amount_of_leave'=>$kasbonreduce
                ]);
                $deduction = new SaturationDeduction;
                $deduction->employee_id         = $request->employee_id;
                $deduction->deduction_option    = $request->deduction_option;
                $deduction->amount              = $request->amount;
                $deduction->month               = date('Y-m');
                $deduction->created_by          = Auth::user()->id;
                $deduction->save();

            }else{
                $deduction = new SaturationDeduction;
                $deduction->employee_id         = $request->employee_id;
                $deduction->deduction_option    = $request->deduction_option;
                $deduction->amount              = $request->amount;
                $deduction->month               = date('Y-m');
                $deduction->created_by          = Auth::user()->id;
                $deduction->save();
            }

            return redirect()->back()->with(['success'=>'Tunjangan berhasil dibuat!']);
        }
    }

    // public function updatepengurangan(request $request){
    //     $validator = Validator::make($request->all(),[
    //         'amount'=>'required',
    //     ]);


        // if($validator->fails()){
        //     return redirect()->back()->with(['error'=>'Required Field!']);
        // }else{
        //     if($request->name =='Kasbon'){

        //         $karyawanamount = $request->total;
        //         $amount = $request->amountold;
        //         $total = $karyawanamount + $amount;
        //         $kasbonreduce = $total - $request->amount;
        //         Employee::where('id',$request->employee_id)->update([
        //             'amount_of_leave'=>$kasbonreduce
        //         ]);
        //         $id = $request->id;
        //         $deduction = SaturationDeduction::find($id);
        //         $deduction->amount              = $request->amount;
        //         $deduction->month               = date('Y-m');
        //         $deduction->created_by          = Auth::user()->id;
        //         $deduction->save();
        //         $cek =  DB::table('pay_slips')->where('employee_id',$deduction->employee_id)->where('salary_month',$deduction->month)->cek();
        //         if($cek){`
        //             $payslips =  DB::table('pay_slips')->where('employee_id',$deduction->employee_id)->where('salary_month',$deduction->month)->update([
        //                 'net_payble' => Employee::updategajibersih($deduction->month, $deduction->employee_id),
        //                 'saturation_deduction' => Employee::updatetunjangan($deduction->month, $deduction->employee_id),
        //                 'slipbyemail'=>0
        //             ]);
        //         }

        //     }else{
        //         $id = $request->id;
        //         $deduction = SaturationDeduction::find($id);
        //         $deduction->amount              = $request->amount;
        //         $deduction->month               = date('Y-m');
        //         $deduction->created_by          = Auth::user()->id;
        //         $deduction->save();
        //         $cek =  DB::table('pay_slips')->where('employee_id',$deduction->employee_id)->where('salary_month',$deduction->month)->cek();
        //         if($cek){
        //             $payslips =  DB::table('pay_slips')->where('employee_id',$deduction->employee_id)->where('salary_month',$deduction->month)->update([
        //                 'net_payble' => Employee::updategajibersih($deduction->month, $deduction->employee_id),
        //                 'saturation_deduction' => Employee::updatetunjangan($deduction->month, $deduction->employee_id),
        //                 'slipbyemail'=>0
        //             ]);
        //         }
        //     }

        //     return redirect()->back()->with(['success'=>'Tunjangan berhasil dibuat!']);
        // }
    // }

    public function edit($id){
        $karyawan = Employee::find($id);
        $jobposition = JobPosition::select('name')->where('id',$karyawan->jobposition_id)->first();
        $department = Department::where('id',$karyawan->department_id)->first();
        $branch = Branch::select('name as branch_name')->where('id',$karyawan->branch_id)->first();
        $kasbon = Kasbon::where('employee_id',$id)->sum('amount');
        $menuaside = 'gaji';

        if($karyawan->level_id != null){
            $jobpositionName = $jobposition->name;
        }else{
            $jobpositionName ="-";
        }
        if($karyawan->department_id != null){
            $departmentname = $department->name;
        }else{
            $departmentname ="-";
        }

        if(isset($branch->branch_name)){
            $branchname = $branch->branch_name;
        }else{
            $branchname ="-";
        }
        return view('admin.gajikaryawan.app-edit',compact('karyawan','jobpositionName','departmentname','branchname','kasbon','menuaside'));
    }

    public function gaji($id){
        $karyawan = Employee::find($id);
        $designation = Designation::select('name as desgination_name')->where('id',$karyawan->designation_id)->first();
        $branch = Branch::select('name as branch_name')->where('id',$karyawan->branch_id)->first();
        $department = Department::where('id',$karyawan->department_id)->first();
        $kasbon = Employee::where('id',$id)->sum('amount_of_leave');

        if($karyawan->designation_id != null){
            $desginationname = $designation->desgination_name;
        }else{
            $desginationname ="-";
        }
        if(isset($branch->branch_name)){
            $branchname = $branch->branch_name;
        }else{
            $branchname ="-";
        }
        if($karyawan->department_id != null){
            $departmentname = $department->name;
        }else{
            $departmentname ="-";
        }
        return view('admin.gajikaryawan.gaji',compact('karyawan','desginationname','branchname','designation','departmentname','kasbon'));
    }


    public function tunjangan($id){
        $karyawan = Employee::find($id);
        $designation = Designation::select('name as desgination_name')->where('id',$karyawan->designation_id)->first();
        $branch = Branch::select('name as branch_name')->where('id',$karyawan->branch_id)->first();
        $department = Department::where('id',$karyawan->department_id)->first();
        $kasbon = Employee::where('id',$id)->sum('amount_of_leave');

        if($karyawan->designation_id != null){
            $desginationname = $designation->desgination_name;
        }else{
            $desginationname ="-";
        }
        if(isset($branch->branch_name)){
            $branchname = $branch->branch_name;
        }else{
            $branchname ="-";
        }
        if($karyawan->department_id != null){
            $departmentname = $department->name;
        }else{
            $departmentname ="-";
        }
        return view('admin.gajikaryawan.tunjangan',compact('karyawan','desginationname','branchname','departmentname','kasbon'));
    }

    public function pengurangan($id){
        $karyawan = Employee::find($id);
        $designation = Designation::select('name as desgination_name')->where('id',$karyawan->designation_id)->first();
        $branch = Branch::select('name as branch_name')->where('id',$karyawan->branch_id)->first();
        $department = Department::where('id',$karyawan->department_id)->first();
        $kasbon = Employee::where('id',$id)->sum('amount_of_leave');

        if($karyawan->designation_id != null){
            $desginationname = $designation->desgination_name;
        }else{
            $desginationname ="-";
        }
        if(isset($branch->branch_name)){
            $branchname = $branch->branch_name;
        }else{
            $branchname ="-";
        }
        if($karyawan->department_id != null){
            $departmentname = $department->name;
        }else{
            $departmentname ="-";
        }

        if($karyawan->amount_of_leave == 0){
            $deduction_option = DB::table('deduction_options')->where('name', '!=', 'Kasbon')->get();
        }
        else{
            $deduction_option = DB::table('deduction_options')->get();
        }
        return view('admin.gajikaryawan.pengurangan',compact('karyawan','desginationname','branchname','departmentname','kasbon', 'deduction_option'));
    }

    public function editpengurangan($id){
        $pengurangan = SaturationDeduction::join('deduction_options','saturation_deductions.deduction_option','=','deduction_options.id')
                    ->select('saturation_deductions.id','deduction_options.name','saturation_deductions.amount')
                    ->where('saturation_deductions.id',$id)
                    ->where('month',date('Y-m'))
                    ->first();
        return response()->json($pengurangan);
    }

    public function export()
    {
        return Excel::download(new ExportKaryawan, 'employee.xlsx');
    }

    public function import(request $request){

        $validator = Validator::make($request->all(),[
            'import' => 'required|mimes:csv,xls,xlsx'
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'file  not yet import!']);
        }else{
            $file = $request->file('import');
            $nama_file = rand().$file->getClientOriginalName();
            $file->move(public_path('/import'),$nama_file);
            Excel::import(new KaryawanImport, public_path('/import/'.$nama_file));
            return redirect()->back()->with(['success'=>'data employee success import !']);
        }

    }

    public function destroytunjangan($id){
        $allow = Allowance::find($id);
        $allow->delete();
        return redirect()->back()->with(['success'=>'Tunjangan berhasil dihapus !']);
    }

    public function destroypengurangan($id){
        $pengurangan = SaturationDeduction::find($id);
        $deduction = DB::table('deduction_options')->where('id',$pengurangan->deduction_option)->first();
        if($deduction->name == 'Kasbon'){
            $karyawan = Employee::find($pengurangan->employee_id);
            $total = $karyawan->amount_of_leave + $pengurangan->amount;
            $karyawan->amount_of_leave = $total;
            $karyawan->save();
            $pengurangan->delete();
        }else{
            $pengurangan->delete();
        }
        return redirect()->back()->with(['success'=>'Pengurangan berhasil dihapus !']);
    }

    public function exportgaji()
    {
        return Excel::download(new ExportGaji,'payroll '.date('F Y').'.xlsx');
    }

    public function importGaji(request $request)
    {

        $validator = Validator::make($request->all(),[
            'import' => 'required|mimes:csv,xls,xlsx'
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'file  not yet import!']);
        }else{
            $file = $request->file('import');
            $import = new ImportGaji();
            $import->setStartRow(3);
            $data = Excel::toArray($import, $file);
            collect(head($data))->each(function ($row, $key) {
                $employee = Employee::where('salary_type','=','Monthly')->orWhere('salary_type','=','Daily')->first();

                if(!empty($employee->salary_type)){

                        $typeComponents = Component::all();
                        foreach($typeComponents as $component){
                            $amount = $this->amountByKey($row, $component['id']);
                            $arrComponents = array('component_id'=> $component['id'],'component'=> $component['name'],'type'=> $component['type'],'amount'=> is_null($amount) ? 0 : $amount);
                            $arrToJson[] =  $arrComponents;
                        }

                        // get id employee
                        $id  = Employee::where('employee_id', $row[1])->pluck('id')->first();

                        $currentDate = date('Y-m-d');
                        $payrollComponentID = PayrollComponent::where('type_adjustment','Adjustment')->whereYear('effective_date', '=', $currentDate)->whereMonth('effective_date', '=', $currentDate)->orWhereYear('end_date','=', $currentDate)->orWhereMonth('end_date','=', $currentDate)->orderByDesc('created_at')->pluck('id')->first();

                        //insert or update into import payroll table
                        ImportPayroll::updateOrCreate([
                            'employee_id' => $id
                        ],
                        [
                            'payroll_component_id' => $payrollComponentID,
                            'total_attendance' => $row[8],
                            'total_working_permonth' => $row[9]
                        ]);

                        //insert or update into payroll employee component
                        PayrollEmployeeComponent::updateOrCreate([
                            'employee_id' => $id,
                        ],
                        [
                            'is_created' => $payrollComponentID,
                            'is_run' => 0,
                            'component' => json_encode($arrToJson),
                        ]);

                }
            });
        }
        return back();
    }

    public function amountByKey($row, $component_id){
        switch($component_id){
            case 1:
                $amount = $row[10];
            break;
            case 2:
                $amount = $row[11];
            break;
            case 3:
                $amount = $row[12];
            break;
            case 4:
                $amount = $row[13];
            break;
            case 5:
                $amount = $row[14];
            break;
            case 6:
                $amount = $row[15];
            break;
            case 7:
                $amount = $row[16];
            break;
            case 8:
                $amount = $row[17];
            break;
            case 9:
                $amount = $row[18];
            break;
            case 10:
                $amount = $row[19];
            break;
            case 11:
                $amount = $row[20];
            break;
            case 12:
                $amount = $row[21];
            break;
            case 13:
                $amount = $row[22];
            break;
            case 14:
                $amount = $row[23];
            break;
            case 15:
                $amount = $row[24];
            break;
            case 16:
                $amount = $row[25];
            break;
            case 17:
                $amount = $row[26];
            break;
            case 18:
                $amount = $row[27];
            break;
            default:
                $amount = $row[28];
            break;
        }

        return $amount;
    }


    public function destroy($id){
        $karyawan = Employee::find($id);
        $karyawan->salary_type = null;
        $karyawan->salary = null;
        $karyawan->net_salary = null;
        $karyawan->save();
        return redirect()->route('gaji')->with(['success'=>'Gaji berhasil dihapus !']);

    }



}
