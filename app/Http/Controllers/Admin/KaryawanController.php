<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\ExportKaryawan;
use App\Employee;
use App\Imports\KaryawanImport;
use App\Organization;
use Validator;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use Datetime;
use App\Education;
use App\EducationInformal;
use App\EducationWorking;
use App\FamilyEmployee;
use App\EmergengyEmployee;
use App\Payslip;
use App\Designation;
use App\User;
use App\Documents;
use App\ContractEmployee;
use Illuminate\Support\Facades\Storage;
class KaryawanController extends Controller
{
    public function index(){
        return view("admin.karyawan.index");
    }

    public function karyawanAjax(request $request){

        $column = array('full_name','employee_id','branch','organization','job_position','job_level','employee_status','join_date','end_date','end_date','email','date_of_birth','place_of_birth','residential_address','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        $branch_id = $request->input('branch_id');
        if($branch_id != null){
            $temp  = Employee::leftjoin('job_position','employees.job_position_id','=','job_position.id')
            ->leftjoin('branches','employees.branch_id','=','branches.id')
            ->leftjoin('organization','employees.organization_id','=','organization.id')
            ->leftjoin('job_level','employees.job_level_id','=','job_level.id')
            ->select('employees.*','branches.name','job_position.name','job_level.name','organization.name')
            ->where('employees.branch_id','=',$branch_id);
            $total = $temp->count();
            $totalFiltered = $total;
        }else{
            $temp  = Employee::leftjoin('job_position','employees.job_position_id','=','job_position.id')
            ->leftjoin('branches','employees.branch_id','=','branches.id')
            ->leftjoin('organization','employees.organization_id','=','organization.id')
            ->leftjoin('job_level','employees.job_level_id','=','job_level.id')
            ->select('employees.*','branches.name as branch','job_position.name as job_position','job_level.name as job_level','organization.name as organization');
            $total = $temp->count();
            $totalFiltered = $total;
        }
        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(employees.full_name) LIKE '%".$search."%' OR LOWER(employees.email) LIKE '%".$search."%' OR LOWER(branches.name) LIKE '%".$search."%' OR LOWER(job_position.name) LIKE '%".$search."%' OR LOWER(job_level.name) LIKE '%".$search."%' OR LOWER(employees.mobile_phone) LIKE '%".$search."%' OR LOWER(employees.phone) LIKE '%".$search."%' OR LOWER(employees.place_of_birth) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                if(isset($row->branch)){
                    $branch = $row->branch;
                }else{
                    $branch = "-";
                }
                if(isset($row->organization)){
                    $organization = $row->organization;
                }else{
                    $organization = "-";
                }
                if(isset($row->job_position)){
                    $job_position = $row->job_position;
                }else{
                    $job_position = "-";
                }
                if(isset($row->job_level)){
                    $job_level = $row->job_level;
                }else{
                    $job_level = "-";
                }
                $name = $row->full_name;
                $parts = explode(" ", $name);
                if(count($parts) > 1) {
                    $lastname = array_pop($parts);
                    $firstname = implode(" ", $parts);
                }
                else
                {
                    $firstname = $name;
                    $lastname = " ";
                }
                $inital = substr($firstname,0,1)."".substr($lastname,0,1);

                if($row->avatar != null){
                    $fullname = '<div class="kt-widget__item">
                                <span class="kt-media kt-media--circle">
                                    <img src="'.asset("demo10/assets/media/users/100_10.jpg").'"alt="image">
                                </span>
                                <div class="kt-widget__info">
                                    <div class="kt-widget__section">
                                        <a href="#" class="kt-widget__username">'.$row->full_name.'</a>
                                        <span class="kt-badge kt-badge--success kt-badge--dot"></span>
                                    </div>
                                    <span class="kt-widget__desc">
                                        '.$organization.'-'.$job_level.'-'.$job_position.'
                                    </span>
                                </div>
                            </div>';
                }else{
                    $fullname = '<div class="kt-widget__item">
                                    <span class="kt-media kt-media--circle">
                                        <div class="kt-widget__pic kt-widget__pic--info kt-font-info kt-font-boldest  kt-hidden-">'.$inital.'</div>
                                    </span>
                                    <div class="kt-widget__info">
                                        <div class="kt-widget__section">
                                            <a  href="'.route('employee.account',['id' => $row->id]).'"  class="kt-widget__username">'.$row->full_name.'</a>
                                            <span class="kt-badge kt-badge--success kt-badge--dot"></span>
                                        </div>
                                        <span class="kt-widget__desc">
                                            '.$organization.'-'.$job_level.'-'.$job_position.'
                                        </span>
                                    </div>
                                </div>';
                }

                $edit     ='<a href="'.route('employee.account',['id' => $row->id]).'"  class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                                <i class="la la-eye"></i>
                            </a>';
                $hapus ='<a href="'.route('employee.destroy',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                <i class="la flaticon-delete"></i>
                            </a>';
                $obj['fullname']            = $fullname;
                $obj['employee_id']         = $row->employee_id;
                $obj['branch']              = $branch;
                $obj['job_position']        = $job_position;
                $obj['job_level']           = $job_level;
                $obj['employeement_status'] = $row->employeement_status;
                $obj['join_date']           = date("d M Y",strtotime($row->join_date));
                $obj['end_date']            = date("d M Y",strtotime($row->end_date));
                $obj['email']               = $row->email;
                $obj['date_of_birth']       = date("d M Y",strtotime($row->date_of_birth));
                $obj['place_of_birth']      = $row->place_of_birth;
                $obj['residential_address'] = "<div class='text-wrap'>".$row->residential_address."</div>";
                $obj['citizien_id_address'] = "<div class='text-wrap'>".$row->citizien_id_address."</div>";
                $obj['actions']             = $edit." ".$hapus;
                $data[] = $obj;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFiltered,
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function create(){
        return view('admin.karyawan.create');
    }

    public function getnamekaryawan($id){
        $karyawan = Employee::find($id);
        return response()->json($karyawan);
    }

    public function updatecuti(request $request){
        $id = $request->id;
        $karyawan = Employee::find($id);
        $karyawan->amount_paid_leave = $request->amount_paid_leave;
        $karyawan->save();
        return redirect()->back()->with(['succes'=>$karyawan->name. " Berhasil Ditambahkan Cuti"]);
    }

    public function store(request $request){

        $validator = Validator::make($request->all(),[
            "first_name"=>"required",
            "last_name"=>"required",
            "email"=>"required|unique:employees",
            "mobile_phone"=>"required",
            "phone"=>"required",
            "place_of_birth"=>"required",
            "date_of_birth"=>"required",
            "gender"=>"required",
            "marital_status"=>"required",
            "blood_type"=>"required",
            "religion"=>"required",
            "identity_type"=>"required",
            "identity_number"=>"required",
            "expired_identity"=>"required",
            "postal_code"=>"required",
            "citizien_id_address"=>"required",
            "residential_address"=>"required",
            "employee_id"=>"required",
            "barcode"=>"required",
            "employee_status"=>"required",
            "join_date"=>"required",
            "end_date"=>"required",
            "branch_id"=>"required",
            "organization_id"=>"required",
            "job_position_id"=>"required",
            "job_level_id"=>"required",
            "schedule_id"=>"required",
            "approval_line_id"=>"required",
            "basic_salary"=>"required",
            "salary_type"=>"required",
            "payment_schedule"=>"required",
            "preorate_setting"=>"required",
            "cost_center_category"=>"required",
            "allowance_overtime"=>"required",
            "bank_name"=>"required",
            "account_holder_name"=>"required",
            "account_number"=>"required",
            "npwp"=>"required",
            "ptkp_status"=>"required",
            "tax_method"=>"required",
            "tax_salary"=>"required",
            "taxable_date"=>"required",
            "employeement_tax_status"=>"required",
            "netto"=>"required",
            "pph21"=>"required",
            "bpjs_kerja_number"=>"required",
            "bpjs_kerja_date"=>"required",
            "bpjs_kesehatan_number"=>"required",
            "bpjs_kesehatan_family"=>"required",
            "bpjs_kesehatan_date"=>"required",
            "bpjs_kesehatan_cost"=>"required",
            "bpjs_jht_cost"=>"required",
            "jaminan_pensiun_cost"=>"required",
            "jaminan_pensiun_date"=>"required",
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->messages()->all());
        }else{
            $employee = new Karyawan;
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->email = $request->email;
            $employee->full_name = $request->first_name." ".$request->last_name;
            $employee->password = "duasisi123";
            $employee->employeement_status="Contract";
            $employee->mobile_phone = $request->mobile_phone;
            $employee->phone = $request->phone;
            $employee->place_of_birth = $request->place_of_birth;
            $employee->date_of_birth = date("Y-m-d",strtotime($request->date_of_birth));
            $employee->gender = $request->gender;
            $employee->marital_status = $request->marital_status;
            $employee->blood_type = $request->blood_type;
            $employee->religion = $request->religion;
            $employee->identity_type = $request->identity_type;
            $employee->identity_number = $request->identity_number;
            $employee->expired_identity = $request->expired_identity;
            $employee->postal_code = $request->postal_code;
            $employee->citizien_id_address = $request->citizien_id_address;
            $employee->residential_address = $request->residential_address;
            $employee->employee_id = $request->employee_id;
            $employee->barcode = $request->barcode;
            $employee->employee_status = $request->employee_status;
            $employee->company_doj = date("Y-m-d",strtotime($request->join_date));
            $employee->join_date = date("Y-m-d",strtotime($request->join_date));
            $employee->end_date = date("Y-m-d",strtotime($request->end_date));
            $employee->branch_id = $request->branch_id;
            $employee->department_id = $request->department_id;
            $employee->organization_id = $request->organization_id;
            $employee->job_position_id = $request->job_position_id;
            $employee->job_level_id = $request->job_level_id;
            $employee->schedule_id = $request->schedule_id;
            $employee->approval_line_id = $request->approval_line_id;
            $employee->basic_salary = $request->basic_salary;
            $employee->salary_type = $request->salary_type;
            $employee->payment_schedule = $request->payment_schedule;
            $employee->preorate_setting = $request->preorate_setting;
            $employee->cost_center_category = $request->cost_center_category;
            $employee->allowance_overtime = $request->allowance_overtime;
            $employee->bank_name = $request->allowance_overtime;
            $employee->account_holder_name = $request->account_holder_name;
            $employee->account_number = $request->account_number;
            $employee->npwp = $request->npwp;
            $employee->ptkp_status = $request->ptkp_status;
            $employee->tax_method = $request->tax_method;
            $employee->tax_salary = $request->tax_salary;
            $employee->taxable_date = $request->taxable_date;
            $employee->employeement_tax_status = $request->employeement_tax_status;
            $employee->netto = $request->netto;
            $employee->pph21 = $request->pph21;
            $employee->bpjs_kerja_number = $request->bpjs_kerja_number;
            $employee->bpjs_kerja_date = date("Y-m-d",strtotime($request->bpjs_kerja_date));
            $employee->bpjs_kesehatan_number = $request->bpjs_kesehatan_number;
            $employee->bpjs_kesehatan_family = $request->bpjs_kesehatan_family;
            $employee->bpjs_kesehatan_date = date("Y-m-d",strtotime($request->bpjs_kesehatan_date));
            $employee->bpjs_kesehatan_cost = $request->bpjs_kesehatan_cost;
            $employee->bpjs_jht_cost = $request->bpjs_jht_cost;
            $employee->jaminan_pensiun_cost = $request->jaminan_pensiun_cost;
            $employee->jaminan_pensiun_date = date("Y-m-d",strtotime($request->jaminan_pensiun_date));
            $employee->created_by = Auth::user()->id;
            $employee->save();
            return redirect()->route('employee')->with(['success'=>'Karyawan Sukses dibuat !']);
        }
    }

    public function nonaktif(request $request){
        $old = Employee::find($request->id1);
        $old->employee_status   = $request->old1;
        $old->reason            = $request->reason1;
        if($request->reason1 == "Mutasi"){
            $karyawan = new Karyawan;
            $karyawan->user_id              = Auth::user()->id;
            $karyawan->id_card              = $request->id_card1;
            $karyawan->name                 = $request->name1;
            $karyawan->dob                  = date("Y-m-d",strtotime($request->dob1));
            $karyawan->pob                  = $request->pob;
            $karyawan->gender               = $request->gender1;
            $karyawan->employee_status      = $request->employee_status1;
            $karyawan->merriage_status      = $request->merriage_status1;
            $karyawan->number_children      = $request->number_children1;
            $karyawan->contract_status      = $request->contract_status1;
            $karyawan->phone                = $request->phone1;
            $karyawan->family_card          = $request->family_card1;
            $karyawan->id_card_address      = $request->id_card_address1;
            $karyawan->address              = $request->address1;
            $karyawan->email                = $request->email1;
            $karyawan->password             = $request->password1;
            $karyawan->branch_id            = $request->branch_id1;
            $karyawan->department_id        = $request->department_id1;
            $karyawan->designation_id       = $request->designation_id1;
            $karyawan->company_doj          = date("Y-m-d",strtotime($request->company_doj1));
            $karyawan->start_date           = date("Y-m-d",strtotime($request->start_date1));
            $karyawan->end_date             = date("Y-m-d",strtotime($request->end_date1));
            $karyawan->account_holder_name  = $request->account_holder_name1;
            $karyawan->account_number       = $request->account_number1;
            $karyawan->bank_name            = $request->bank_name1;
            $karyawan->tax_payer_id         = $request->tax_payer_id1;
            $karyawan->documents            = $request->documents1;
            $karyawan->created_by           = Auth::user()->id;
            $karyawan->save();
        }
        $old->end_date          = date('Y-m-d',strtotime($request->end_date1));
        $old->save();
            return redirect()->back()->with(['success'=>'Karyawan Sukses dinonaktifkan !']);
    }


    public static function getinitialname($names){
        $name = $names;
        $parts = explode(" ", $name);
        if(count($parts) > 1) {
            $lastname = array_pop($parts);
            $firstname = implode(" ", $parts);
        }
        else
        {
            $firstname = $name;
            $lastname = " ";
        }
        $inital = substr($firstname,0,1)."".substr($lastname,0,1);
        return $inital;
    }

    public static function getAgeEmployee($age){
        $dateOfBirth = date("Y-m-d",strtotime($age));
        $today = date("Y-m-d");
        $diff  = date_diff(date_create($dateOfBirth), date_create($today));
        $age   = $diff->format('%y');
        return $age;
    }

    /* Begin Personal  */
    public function account($id){
        $karyawan = Employee::find($id);
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        $age      = KaryawanController::getAgeEmployee($karyawan->date_of_birth);
        return view('admin.karyawan.account.personal.index',compact('karyawan','initial','age'));
    }

    public function family_ajax(request $request){
        $id = $request->id;
        $column = array('name','relationship','birthdate','marital_status','job','religion','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = DB::table('family_employee')->select('id','name','relationship','birthdate','marital_status','gender','job','religion','id as actions')
                    ->where('employee_id',$id);
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(name) LIKE '%".$search."%' OR LOWER(relationship) LIKE '%".$search."%' OR LOWER(marital_status) LIKE '%".$search."%' OR LOWER(gender) LIKE '%".$search."%' OR LOWER(job) LIKE '%".$search."%' OR LOWER(religion) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $edit='<a href="javascript:;" data-attr="'.route('employee.account.personal.family.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-family" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus='<a  href="javascript:;" data-attr="'.route('employee.account.personal.family.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-family" title="Delete">
                            <i class="la flaticon-delete"></i>
                        </a>';
                $obj['name']            = $row->name;
                $obj['relationship']    = $row->relationship;
                $obj['birthdate']       = $row->birthdate;
                $obj['marital_status']  = $row->marital_status;
                $obj['gender']          = $row->gender;
                $obj['job']             = $row->job;
                $obj['religion']        = $row->religion;
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

    public function family_create($id){
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.personal.create-family',compact('karyawan'));
    }

    public function family_store(request $request, $id){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'relationship'=>'required',
            'birthdate'=>'required',
            'marital_status'=>'required',
            'gender'=>'required',
            'job'=>'required',
            'religion'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $family = new FamilyEmployee;
            $family->name = $request->name;
            $family->employee_id = $id;
            $family->relationship = $request->relationship;
            $family->birthdate = date("Y-m-d",strtotime($request->birthdate));
            $family->marital_status = $request->marital_status;
            $family->gender = $request->gender;
            $family->job = $request->job;
            $family->religion = $request->religion;
            $family->save();
        }
        return redirect()->back()->with(['success'=>'Family Employee Success Created !']);
    }

    public function family_edit($id){
        $family = FamilyEmployee::find($id);
        return view('admin.karyawan.account.personal.edit-family',compact('family'));
    }


    public function personal_request_edit($id){
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.personal.edit.personal',compact('karyawan'));
    }


    public function personal_request_update(request $request, $id){

        $karyawan = Employee::find($id);
        $karyawan->first_name           = $request->req_first_name;
        $karyawan->last_name            = $request->req_last_name;
        $karyawan->full_name            = $request->req_first_name." ".$request->req_last_name;
        $karyawan->mobile_phone         = $request->req_mobile_phone;
        $karyawan->phone                = $request->req_phone;
        $karyawan->email                = $request->req_email;
        $karyawan->place_of_birth       = $request->req_place_of_birth;
        $karyawan->date_of_birth        = date("Y-m-d",strtotime($request->req_date_of_birth));
        $karyawan->blood_type           = $request->req_blood_type;
        $karyawan->marital_status       = $request->req_marital_status;
        $karyawan->religion             = $request->req_religion;
        $karyawan->is_req_personal      = 0;
        $karyawan->save();
        if($karyawan->is_req_personal == 0){

            $karyawan = Employee::find($id);
            $karyawan->req_first_name       = null;
            $karyawan->req_last_name        = null;
            $karyawan->req_mobile_phone     = null;
            $karyawan->req_phone            = null;
            $karyawan->req_email            = null;
            $karyawan->req_place_of_birth   = null;
            $karyawan->req_date_of_birth    = null;
            $karyawan->req_blood_type       = null;
            $karyawan->req_marital_status   = null;
            $karyawan->req_religion         = null;
            $karyawan->save();
        }
        return redirect()->back()->with(['success'=>'Request Approvement!']);
    }



    public function family_update(request $request, $id){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'relationship'=>'required',
            'birthdate'=>'required',
            'marital_status'=>'required',
            'gender'=>'required',
            'job'=>'required',
            'religion'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $family = FamilyEmployee::find($id);
            $family->name = $request->name;
            $family->relationship = $request->relationship;
            $family->birthdate = date("Y-m-d",strtotime($request->birthdate));
            $family->marital_status = $request->marital_status;
            $family->gender = $request->gender;
            $family->job = $request->job;
            $family->religion = $request->religion;
            $family->save();
        }
        return redirect()->back()->with(['success'=>'Family Employee Success Update !']);

    }

    public function family_request_update(request $request, $id){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'relationship'=>'required',
            'birthdate'=>'required',
            'marital_status'=>'required',
            'gender'=>'required',
            'job'=>'required',
            'religion'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $family = FamilyEmployee::find($id);
            $family->name = $request->name;
            $family->relationship = $request->relationship;
            $family->birthdate = date("Y-m-d",strtotime($request->birthdate));
            $family->marital_status = $request->marital_status;
            $family->gender = $request->gender;
            $family->job = $request->job;
            $family->religion = $request->religion;
            $family->save();
        }
        return redirect()->back()->with(['success'=>'Family Employee Success Update !']);

    }

    public function family_show($id){
        $family = FamilyEmployee::find($id);
        return view('admin.karyawan.account.personal.show-family',compact('family'));
    }

    public function family_delete($id){
        $family = FamilyEmployee::find($id);
        $family->delete();
        return redirect()->back()->with(['success'=>'Family Employee Success Deleted !']);
    }

    public function emergency_ajax(request $request){
        $id = $request->id;
        $column = array('name','relationship','phone_number','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = EmergengyEmployee::select('id','name','relationship','phone_number','id as actions')
                    ->where('employee_id',$id);
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(name) LIKE '%".$search."%' OR LOWER(relationship) LIKE '%".$search."%' OR LOWER(phone_number) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $edit='<a href="javascript:;" data-attr="'.route('employee.account.personal.emergency.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-emergency" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus='<a  href="javascript:;" data-attr="'.route('employee.account.personal.emergency.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-emergency" title="Delete">
                            <i class="la flaticon-delete"></i>
                        </a>';
                $obj['name']            = $row->name;
                $obj['relationship']    = $row->relationship;
                $obj['phone_number']    = $row->phone_number;
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

    public function emergency_create($id){
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.personal.create-emergency',compact('karyawan'));
    }

    public function emergency_store(request $request, $id){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'relationship'=>'required',
            'phone_number'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $emergency = new EmergengyEmployee;
            $emergency->name = $request->name;
            $emergency->employee_id = $id;
            $emergency->relationship = $request->relationship;
            $emergency->phone_number = $request->phone_number;
            $emergency->save();
        }
        return redirect()->back()->with(['success'=>'Emergency Employee Success Created !']);
    }

    public function emergency_edit($id){
        $emergency = EmergengyEmployee::find($id);
        return view('admin.karyawan.account.personal.edit-emergency',compact('emergency'));
    }

    public function emergency_update(request $request, $id){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'relationship'=>'required',
            'phone_number'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $emergency = EmergengyEmployee::find($id);
            $emergency->name = $request->name;
            $emergency->relationship = $request->relationship;
            $emergency->phone_number = $request->phone_number;
            $emergency->save();
        }
        return redirect()->back()->with(['success'=>'Emergency Employee Success Update !']);

    }

    public function emergency_show($id){
        $emergency = EmergengyEmployee::find($id);
        return view('admin.karyawan.account.personal.show-emergency',compact('emergency'));
    }

    public function emergency_delete($id){
        $emergency = EmergengyEmployee::find($id);
        $emergency->delete();
        return redirect()->back()->with(['success'=>'Emergency Employee Success Deleted !']);
    }
    /* End Personal  */


    /* Begin Employement Data  */
    public function employementdata($id){
        $karyawan = Employee::leftjoin('branches','employees.branch_id','=','branches.id')
                            ->leftjoin('departments','employees.department_id','=','departments.id')
                            ->leftjoin("job_position",'employees.job_position_id','=','job_position.id')
                            ->leftjoin("job_level",'employees.job_level_id','=','job_level.id')
                            ->select("employees.*",'job_position.name as jobposition','branches.name as branch', 'departments.name as department','job_level.name as job_level')
                            ->where('employees.id',$id)->first();
        $organization = Organization::select('name','id')->where('id',$karyawan->organization_id)->first();
        $relatebranch = Employee::leftjoin('branches','employees.branch_id','=','branches.id')
                                  ->leftjoin('departments','employees.branch_id','=','branches.id')
                                  ->leftjoin("job_position",'employees.job_position_id','=','job_position.id')
                                  ->select("employees.*",'job_position.name as jobposition','branches.name as branch')
                                  ->where("organization_id",$organization->id)
                                  ->where("employee_status","Aktif")
                                  ->get();
        $initial = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.employeement-data.index',compact('karyawan','initial','relatebranch'));
    }
    /* End Employement Data  */


    /* Begin education */
    public function education($id){
        $karyawan = Employee::find($id);
        $initial = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.education.index',compact('karyawan','initial'));
    }

    public function educationformalajax(request $request){
        $id = $request->id;
        $column = array('grade','institute_name','major','start_year','end_year','score','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = DB::table('education')->select('id','grade','institute_name','major','start_year','end_year','score','id as actions')
                    ->where('employee_id',$id);
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(grade) LIKE '%".$search."%' OR LOWER(institute_name) LIKE '%".$search."%' OR LOWER(major) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $edit='<a href="javascript:;" data-attr="'.route('employee.account.education.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-education" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus='<a  href="javascript:;" data-attr="'.route('employee.account.education.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-education" title="Delete">
                            <i class="la flaticon-delete"></i>
                        </a>';
                $obj['grade']             = $row->grade;
                $obj['institute_name']    = $row->institute_name;
                $obj['major']             = $row->major;
                $obj['start_year']        = $row->start_year;
                $obj['end_year']          = $row->end_year;
                $obj['score']             = $row->score;
                $obj['actions']           = $edit.''.$hapus;
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

    public function create_education($id){
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.education.create-formal',compact("karyawan"));
    }

    public function store_education(request $request, $id){
        $validator = Validator::make($request->all(),[
            'grade'=>'required',
            'institute_name'=>'required',
            'major'=>'required',
            'score'=>'required',
            'start_year'=>'required',
            'end_year'=>'required',

        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $education = new Education;
            $education->employee_id = $id;
            $education->grade = $request->grade;
            $education->institute_name = $request->institute_name;
            $education->major = $request->major;
            $education->score = $request->score;
            $education->start_year = $request->start_year;
            $education->end_year = $request->end_year;
            $education->save();
            return redirect()->back()->with(['success'=>'Your Education Successfull Created !']);
        }
    }

    public function edit_education($id){
        $education = Education::find($id);
        return view('admin.karyawan.account.education.edit-formal',compact('education'));
    }

    public function update_education(request $request,$id){
        $validator = Validator::make($request->all(),[
            'grade'=>'required',
            'institute_name'=>'required',
            'major'=>'required',
            'score'=>'required',
            'start_year'=>'required',
            'end_year'=>'required',

        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $education = Education::find($id);
            $education->grade = $request->grade;
            $education->institute_name = $request->institute_name;
            $education->major = $request->major;
            $education->score = $request->score;
            $education->start_year = $request->start_year;
            $education->end_year = $request->end_year;
            $education->save();
            return redirect()->back()->with(['success'=>'Your Education Successfull Updated !']);
        }
    }

    public function show_education($id){
        $education = Education::find($id);
        return view('admin.karyawan.account.education.show-education',compact('education'));
    }

    public function delete_education($id){
        $education = Education::find($id);
        $education->delete();
        return redirect()->back()->with(['success'=>'Your Education Successfull Delete !']);
    }

    public function educationinformalajax(request $request){
        $id = $request->id;
        $column = array("name","held_by","start_date","end_date","duration","fee","certificate","actions");
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = DB::table('education_informal')->select('id','name','held_by','start_date','end_date','duration','dayshour','fee',"certificate",'id as actions')
                    ->where('employee_id',$id);
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(name) LIKE '%".$search."%' OR LOWER(held_by) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $edit='<a href="javascript:;" data-attr="'.route('employee.account.education.informal.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-education-informal" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus='<a  href="javascript:;" data-attr="'.route('employee.account.education.informal.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-education-informal" title="Delete">
                            <i class="la flaticon-delete"></i>
                        </a>';
                if($row->certificate != null){
                    $certificate = '<a href="'.asset('storage/certificate/'.$row->certificate).'"  target="_blank"  class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View Certificate">
                                        <i class="la flaticon-file"></i>
                                    </a>';
                }else{
                    $certificate  = "No";
                }
                $obj['name']        = $row->name;
                $obj['held_by']     = $row->held_by;
                $obj['start_date']  = date("d M Y",strtotime($row->start_date));
                $obj['end_date']    = date("d M Y",strtotime($row->end_date));
                $obj['duration']    = $row->dayshour." ".$row->duration;
                $obj['fee']         = $row->fee;
                $obj['certificate'] = $certificate;
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

    public function create_education_informal($id){
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.education.create-informal',compact('karyawan'));
    }

    public function store_informal_education(request $request, $id){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'held_by'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'duration'=>'required',
            'dayshour'=>'required',
            'expired_date'=>'required',
            'fee'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            if($request->hasFile('certificate')){
                $filenameWithExt = $request->file('certificate')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('certificate')->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                $path = $request->file('certificate')->storeAs('public/certificate',$fileNameToStore);
            }else{
                $fileNameToStore = "No";
            }
            $education = new EducationInformal;
            $education->employee_id = $id;
            $education->name = $request->name;
            $education->held_by = $request->held_by;
            $education->start_date      = date('Y-m-d',strtotime($request->start_date));
            $education->end_date        = date('Y-m-d',strtotime($request->end_date));
            $education->duration        = $request->duration;
            $education->dayshour        = $request->dayshour;
            $education->expired_date    = date('Y-m-d',strtotime($request->expired_date));
            $education->fee = $request->fee;
            $education->certificate = $fileNameToStore;
            $education->save();
            return redirect()->back()->with(['success'=>'Your Education Informal Successfull Update !']);
        }
    }

    public function edit_education_informal($id){
        $education = EducationInformal::find($id);
        return view('admin.karyawan.account.education.edit-informal',compact('education'));
    }

    public function update_education_informal(request $request, $id){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'held_by'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'duration'=>'required',
            'dayshour'=>'required',
            'expired_date'=>'required',
            'fee'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $education = EducationInformal::find($id);
            if($request->hasFile('certificate')){
                $filenameWithExt = $request->file('certificate')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('certificate')->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                $path = $request->file('avatar')->storeAs('public/avatars',$fileNameToStore);
            }else{
                $fileNameToStore = $education->certificate;
            }
            $education->name            = $request->name;
            $education->held_by         = $request->held_by;
            $education->start_date      = date('Y-m-d',strtotime($request->start_date));
            $education->end_date        = date('Y-m-d',strtotime($request->end_date));
            $education->duration        = $request->duration;
            $education->dayshour        = $request->dayshour;
            $education->expired_date    = date('Y-m-d',strtotime($request->expired_date));
            $education->fee             = $request->fee;
            $education->certificate     = $fileNameToStore;
            $education->save();
            return redirect()->back()->with(['success'=>'Your Education informal Successfull Updated !']);
        }
    }

    public function show_education_informal($id){
        $education = EducationInformal::find($id);
        return view('admin.karyawan.account.education.show-education-informal',compact('education'));
    }

    public function delete_education_informal($id){
        $education = EducationInformal::find($id);
        $path = '/public/certificate/'.$education->certificate;
        Storage::delete($path);
        if(!Storage::exists($path)){
            $education->delete();
        }
        return redirect()->back()->with(['success'=>'Your Education informal Successfull Deleted !']);
    }

    public function educationworkingajax(request $request){
        $id = $request->id;
        $column = array("company","position","froms","tos","length","actions");
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = DB::table('education_working')->select('id','company','position','froms','tos','id as actions')
                    ->where('employee_id',$id);
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(company) LIKE '%".$search."%' OR LOWER(position) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $date1 = date("Y-m-d",strtotime($row->froms));
                $date2 = date("Y-m-d",strtotime($row->tos));
                $diff = abs(strtotime($date2)-strtotime($date1));
                $years = floor($diff / (365*60*60*24));
                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                $merge = $years." Year ".$months." Month ".$days." days";

                $edit='<a href="javascript:;" data-attr="'.route('employee.account.education.working.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-education-working" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus='<a  href="javascript:;" data-attr="'.route('employee.account.education.working.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-education-working" title="Delete">
                            <i class="la flaticon-delete"></i>
                        </a>';
                $obj['company']         = $row->company;
                $obj['position']        = $row->position;
                $obj['froms']           = date("d M Y",strtotime($row->froms));
                $obj['tos']             = date("d M Y",strtotime($row->tos));
                $obj['length']          = $merge;
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

    public function create_education_working($id){
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.education.create-working',compact('karyawan'));
    }

    public function store_education_working(request $request, $id){
        $validator = Validator::make($request->all(),[
            'company'=>'required',
            'position'=>'required',
            'froms'=>'required',
            'tos'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $education = new EducationWorking;
            $education->employee_id  = $id;
            $education->company      = $request->company;
            $education->position     = $request->position;
            $education->froms        = date('Y-m-d',strtotime($request->froms));
            $education->tos          = date('Y-m-d',strtotime($request->tos));
            $education->save();
            return redirect()->back()->with(['success'=>'Your Education informal Successfull Created !']);
        }
    }

    public function edit_education_working($id){
        $education = EducationWorking::find($id);
        return view('admin.karyawan.account.education.edit-working',compact('education'));
    }

    public function update_education_working(request $request, $id){
        $validator = Validator::make($request->all(),[
            'company'=>'required',
            'position'=>'required',
            'froms'=>'required',
            'tos'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error'=>'Required Field!']);
        }else{
            $education = EducationWorking::find($id);
            $education->company      = $request->company;
            $education->position     = $request->position;
            $education->froms        = date('Y-m-d',strtotime($request->froms));
            $education->tos          = date('Y-m-d',strtotime($request->tos));
            $education->save();
            return redirect()->back()->with(['success'=>'Your Education Working Successfull Updated !']);
        }
    }

    public function show_education_working($id){
        $education = EducationWorking::find($id);
        return view('admin.karyawan.account.education.show-working',compact('education'));
    }

    public function delete_education_working($id){
        $education = EducationWorking::find($id);
        $education->delete();
        return redirect()->back()->with(['success'=>'Your Education Working Successfull Deleted !']);
    }

    /* End  education  */

    /* Begin  Payroll  */
    public function payrollinfo($id){
        $karyawan = Employee::find($id);
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.payroll.index',compact('karyawan','initial'));
    }

    public function payslip($id){
        $karyawan = Employee::find($id);
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.payroll.payslip',compact('karyawan','initial'));
    }

    public function payslipAjax(request $request){
        $id = $request->id;
        $salary_month = $request->input('salary_month');
        $column = array('salary_month','payroll_cut_off','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = Payslip::join('employees','pay_slips.employee_id','=','employees.id')
                ->join('payslip_types','employees.salary_type','=','payslip_types.id')
                ->select('pay_slips.id','pay_slips.salary_month',"pay_slips.id as payroll_cut_off",'pay_slips.id as actions')
                ->where('pay_slips.employee_id',$id)
                ->orderBy('pay_slips.salary_month','DESC');
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(pay_slips.salary_month) LIKE '%".$search."%' OR LOWER(payslip_types.name) LIKE '%".$search."%' OR LOWER(pay_slips.basic_salary) LIKE '%".$search."%' OR LOWER(pay_slips.net_payble) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                $paid ='<a href="'.route('employee.payroll.payslip.detail',$row->id).'" class="btn btn-secondary btn-sm" title="View Payslip">
                            View payslip
                        </a>';
                $obj['salary_month']        = date('F',strtotime($row->salary_month));
                $obj['payroll_cut_off']     = "26 ".date("M",strtotime("-1 month",strtotime($row->salary_month)))." - "."25 ".date("M",strtotime($row->salary_month))." ".date("Y",strtotime($row->salary_month));
                $obj['actions']             = $paid;
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
    public function payslipdetail($id){

        $payslip = Payslip::find($id);
        $karyawan = Employee::where("id",$payslip->employee_id)->first();
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.payroll.detail',compact('payslip','initial','karyawan'));
    }

    public function downloadpayslippdf($id){
        $payslip = DB::table('pay_slips')->where('id',$id)->latest()->first();
        $employee = Employee::find($payslip->employee_id);
        $desgination = Designation::find($employee->designation_id);
        $signature = User::find($payslip->created_by);
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => storage_path().'/app/public/pdf',
            'format' => 'A4-P',
            'margin_left'=>10,
            'margin_right'=>10,
            'margin_top'=>10,
            'margin_bottom'=>15,
            'margin_header'=>10,
        ]);
        $mpdf->SetTitle($employee->name.' | '.date('F Y',strtotime($payslip->salary_month)));
        $mpdf->WriteHTML(view('karyawan.account.payroll.print-payslip',compact('payslip','employee','desgination','signature')));
        $mpdf->Output();
    }
    /* End  Payroll  */


    /* Begin   Files  */
    public function files($id){
        $karyawan = Employee::find($id);
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.files.index',compact('initial','karyawan'));
    }

    public function documentsAjax(request $request){
        $id = $request->id;
        $column = array("name","documents","actions");
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = DB::table('documents')->select('id','name','documents','id as actions')
                    ->where('employee_id',$id);
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
                $edit='<a href="javascript:;" data-attr="'.route('employee.files.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-files" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus='<a  href="javascript:;" data-attr="'.route('employee.files.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-files" title="Delete">
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

    public function createfile($id){
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.files.create',compact('karyawan'));
    }


    public function storefile(request $request, $id){
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
            $documents->employee_id = $id;
            $documents->name        = $request->name;
            $documents->documents   = $fileNameToStore;
            $documents->save();
            return redirect()->back()->with(['success'=>'Your Documents Successfull Created !']);
        }
    }

    public function editfile($id){
        $documents   = Documents::find($id);
        return view('admin.karyawan.account.files.edit',compact("documents"));
    }

    public function updatefile(request $request, $id){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            // 'documents' => 'required|mimes:jpeg,png|size:700',
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['danger'=>$validator->errors()->first()]);
        }else{

            $documents   = Documents::find($id);
            $path = '/public/documents/'.$documents->documents;
            Storage::delete($path);
            if(!Storage::exists($path)){
                if($request->hasFile('documents')){
                    $filenameWithExt = $request->file('documents')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('documents')->getClientOriginalExtension();
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;
                    $path = $request->file('documents')->storeAs('public/documents',$fileNameToStore);
                }else{
                    $fileNameToStore = $documents->documents;
                }
                $documents                  = Documents::find($id);
                $documents->name            = $request->name;
                $documents->documents   = $fileNameToStore;
                $documents->save();
                return redirect()->back()->with(['success'=>'Your Documents Successfull Created !']);
            }
        }
    }

    public function showfile($id){
        $documents   = Documents::find($id);
        return view('admin.karyawan.account.files.show',compact("documents"));
    }
    public function deletefile($id){
        $documents   = Documents::find($id);
        $path = '/public/documents/'.$documents->documents;
        Storage::delete($path);
        if(!Storage::exists($path)){
            $documents->delete();
        }
        return redirect()->back()->with(['success'=>'Your Documents Successfull Deleted !']);
    }
    /* End   Files  */


    /* Begin Contract */

    public function contract($id){
        $karyawan = Employee::find($id);
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.contract.index',compact('initial','karyawan'));
    }

    public function contractAjax(request $request){
        $id = $request->id;
        $column = array("start_date","end_date","contract","actions");
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = DB::table('contract_employee')->select('id','start_date','end_date','contract','id as actions')
                    ->where('employee_id',$id);
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
                $edit='<a href="javascript:;" data-attr="'.route('employee.contract.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-contract" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus='<a  href="javascript:;" data-attr="'.route('employee.contract.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-contract" title="Delete">
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
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.contract.create',compact('karyawan'));
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
            $contract->employee_id = $id;

            $contract->start_date  = date("Y-m-d",strtotime($request->start_date));
            $contract->end_date    = date("Y-m-d",strtotime($request->end_date));
            $contract->contract   = $fileNameToStore;
            $contract->save();
            return redirect()->back()->with(['success'=>'Your Documents Successfull Created !']);
        }
    }

    public function editContract($id){
        $contract    = ContractEmployee ::find($id);
        return view('admin.karyawan.account.contract.edit',compact("contract"));
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
        return view('admin.karyawan.account.contract.show',compact("contract"));
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

    /* End  Contract */































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
            $data = Excel::toArray(new KaryawanImport, $file);
            $nama_file = rand().$file->getClientOriginalName();
            $file->move(public_path('/import'),$nama_file);
            $import = Excel::import(new KaryawanImport, public_path('/import/'.$nama_file));
            return redirect()->back()->with(['success'=>'Data Karyawan Suskses di Import !']);
        }

    }

    public function destroy($id){
        $karyawan = Employee::find($id);
        $karyawan->delete();
        return redirect()->route('karyawan')->with(['success'=>'Data Karyawan Berhasil Dihapus !']);
    }


}
