<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Auth;
use App\Karyawan;
use App\Designation;
use App\Branch;
use App\Delegation;
use App\JobPosition;
// use DB;
// use Validator;
use App\Education;
use App\Organization;
use App\EducationInformal;
use App\EducationWorking;
use App\FamilyEmployee;
use App\EmergengyEmployee;
use App\ScheduleAssignment;
use App\Shift;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\EmployeeRequestShift;
use App\Http\Controllers\karyawan\InboxController;
use App\Employee;
use App\Http\Controllers\Admin\KaryawanController;
use App\Inbox;
use App\LogTimeOffBalance;
use App\StatusRequestDelegation;
use App\StatusRequestTimeOff;
use App\Timeoff;
use App\TimeoffBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{

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

    public function account($id){
        $karyawan = Karyawan::find($id);
        $dateOfBirth = date("Y-m-d",strtotime($karyawan->date_of_birth));
        $today = date("Y-m-d");
        $diff  = date_diff(date_create($dateOfBirth), date_create($today));
        $age   = $diff->format('%y');
        $initial = AccountController::getinitialname(Auth::guard("emp")->user()->full_name);
        return view('karyawan.account.personal.index',compact('initial','age'));
    }

    public function personal_request_edit($id){
        $karyawan = Karyawan::find($id);
        return view('karyawan.account.personal.edit.personal',compact('karyawan'));
    }

    public function personal_request_update(request $request, $id){
        $karyawan = Karyawan::find($id);
        $karyawan->req_first_name       = $request->first_name;
        $karyawan->req_last_name        = $request->last_name;
        $karyawan->req_mobile_phone     = $request->mobile_phone;
        $karyawan->req_phone            = $request->phone;
        $karyawan->req_email            = $request->email;
        $karyawan->req_place_of_birth   = $request->place_of_birth;
        $karyawan->req_date_of_birth    = Carbon::createFromFormat('m/d/Y', $request->date_of_birth)->format("Y-m-d");
        $karyawan->req_blood_type       = $request->blood_of_type;
        $karyawan->req_marital_status   = $request->marital_status;
        $karyawan->req_religion         = $request->religion;
        $karyawan->is_req_personal      = 1;
        $karyawan->save();
        return redirect()->back()->with(['success'=>'Personal data success request to admin !']);
    }

    public function identity_request_edit($id){
        $karyawan = Karyawan::find($id);
        return view('karyawan.account.personal.edit.identity',compact('karyawan'));
    }

    public function identity_request_update(request $request, $id){
        $karyawan = Karyawan::find($id);
        $karyawan->req_identity_type    = $request->identity_type;
        $karyawan->req_identity_number  = $request->identity_number;
        $karyawan->req_postal_code      = $request->postal_code;
        $karyawan->req_expired_identity = $request->expired_identity;
        $karyawan->req_citizien_id_address = $request->citizien_id_address;
        $karyawan->req_residential_address = $request->residential_address;
        $karyawan->is_req_identity      = 1;
        $karyawan->save();
        return redirect()->back()->with(['success'=>'Personal Identity data success request to admin !']);
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
                    ->where('employee_id',Auth::guard('emp')->user()->id);
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
                $edit='<a href="javascript:;" data-attr="'.route('emp.account.personal.family.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-family" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus='<a  href="javascript:;" data-attr="'.route('emp.account.personal.family.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-family" title="Delete">
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
        $karyawan = Karyawan::find($id);
        return view('karyawan.account.personal.create-family',compact('karyawan'));
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
            $family->employee_id = Auth::guard('emp')->user()->id;
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
        return view('karyawan.account.personal.edit-family',compact('family'));
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

    public function family_show($id){
        $family = FamilyEmployee::find($id);
        return view('karyawan.account.personal.show-family',compact('family'));
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
                ->where('employee_id',Auth::guard('emp')->user()->id);

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
                $edit='<a href="javascript:;" data-attr="'.route('emp.account.personal.emergency.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-emergency" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus='<a  href="javascript:;" data-attr="'.route('emp.account.personal.emergency.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-emergency" title="Delete">
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
        $karyawan = Karyawan::find($id);
        return view('karyawan.account.personal.create-emergency',compact('karyawan'));
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
        return view('karyawan.account.personal.edit-emergency',compact('emergency'));
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
        return view('karyawan.account.personal.show-emergency',compact('emergency'));
    }

    public function emergency_delete($id){
        $emergency = EmergengyEmployee::find($id);
        $emergency->delete();
        return redirect()->back()->with(['success'=>'Emergency Employee Success Deleted !']);
    }


    public function employementdata($id){
        $karyawan = Karyawan::leftjoin('branches','employees.branch_id','=','branches.id')
                            ->leftjoin("job_position",'employees.job_position_id','=','job_position.id')
                            ->leftjoin("job_level",'employees.job_level_id','=','job_level.id')
                            ->select("employees.*",'job_position.name as jobposition','branches.name as branch','job_level.name as job_level')
                            ->where('employees.id',$id)->first();
        $organization = Organization::select('name','id')->where('id',$karyawan->organization_id)->first();
        $relatebranch = Karyawan::leftjoin('branches','employees.branch_id','=','branches.id')
                                  ->leftjoin("job_position",'employees.job_position_id','=','job_position.id')
                                  ->select("employees.*",'job_position.name as jobposition','branches.name as branch')
                                  ->where("organization_id",$organization->id)
                                  ->where("employee_status","Aktif")
                                  ->get();
        $initial = AccountController::getinitialname(Auth::guard("emp")->user()->name);
        return view('karyawan.account.employeement-data.index',compact('karyawan','initial','relatebranch'));
    }

    public function education($id){
        $karyawan = Karyawan::find($id);
        $initial = AccountController::getinitialname(Auth::guard("emp")->user()->full_name);
        return view('karyawan.account.education.index',compact('karyawan','initial'));
    }

    public function educationformalajax(request $request){
        $column = array('grade','institute_name','major','start_year','end_year','score','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = DB::table('education')->select('id','grade','institute_name','major','start_year','end_year','score','id as actions')
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
            $boot   = $temp->whereRaw("(LOWER(grade) LIKE '%".$search."%' OR LOWER(institute_name) LIKE '%".$search."%' OR LOWER(major) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $edit='<a href="javascript:;" data-attr="'.route('emp.account.education.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-education" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus='<a  href="javascript:;" data-attr="'.route('emp.account.education.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-education" title="Delete">
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

    public function create_education(){
        return view('karyawan.account.education.create-formal');
    }

    public function store_education(request $request){
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
            $education->employee_id = Auth::guard("emp")->user()->id;
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
        return view('karyawan.account.education.edit-formal',compact('education'));
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
            $education->employee_id = Auth::guard("emp")->user()->id;
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
        return view('karyawan.account.education.show-education',compact('education'));
    }
    public function delete_education($id){
        $education = Education::find($id);
        $education->delete();
        return redirect()->back()->with(['success'=>'Your Education Successfull Delete !']);
    }

    public function educationinformalajax(request $request){
        $column = array("name","held_by","start_date","end_date","duration","fee","certificate","actions");
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = DB::table('education_informal')->select('id','name','held_by','start_date','end_date','duration','dayshour','fee',"certificate",'id as actions')
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
            $boot   = $temp->whereRaw("(LOWER(name) LIKE '%".$search."%' OR LOWER(held_by) LIKE '%".$search."%')")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $edit='<a href="javascript:;" data-attr="'.route('emp.account.education.informal.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-education-informal" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus='<a  href="javascript:;" data-attr="'.route('emp.account.education.informal.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-education-informal" title="Delete">
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

    public function create_education_informal(){
        return view('karyawan.account.education.create-informal');
    }

    public function store_informal_education(request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'held_by'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'duration'=>'required',
            'dayshour'=>'required',
            'expired_date'=>'required',
            'fee'=>'required',
            // 'certificate'=>'required'

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
            $education->employee_id = Auth::guard("emp")->user()->id;
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
        return view('karyawan.account.education.edit-informal',compact('education'));
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
            $education->employee_id     = Auth::guard("emp")->user()->id;
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
        return view('karyawan.account.education.show-education-informal',compact('education'));
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
        $column = array("company","position","froms","tos","length","actions");
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = DB::table('education_working')->select('id','company','position','froms','tos','id as actions')
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

                $edit='<a href="javascript:;" data-attr="'.route('emp.account.education.working.edit',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-education-working" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus='<a  href="javascript:;" data-attr="'.route('emp.account.education.working.show',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-education-working" title="Delete">
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

    public function create_education_working(){
        return view('karyawan.account.education.create-working');
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
            $education->employee_id  = Auth::guard("emp")->user()->id;
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
        return view('karyawan.account.education.edit-working',compact('education'));
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
            $education->employee_id  = Auth::guard("emp")->user()->id;
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
        return view('karyawan.account.education.show-working',compact('education'));
    }

    public function delete_education_working($id){
        $education = EducationWorking::find($id);
        $education->delete();
        return redirect()->back()->with(['success'=>'Your Education Working Successfull Deleted !']);
    }

    public function changeemailpassword(request $request, $id){
        $karyawan = Karyawan::find($id);
        $karyawan->password = Hash::make($request->password);
        $karyawan->save();
        return redirect()->back()->with(['success'=>'Email Atau Password Berhasil Di Ubah !']);
    }

    public function changedocuments(request $request, $id){
        $ktp        =$request->ktps;
        $kk         =$request->kks;
        $npwp       =$request->npwps;
        $foto       =$request->fotos;
        $ijazah     =$request->ijazahs;
        $kontrak    =$request->kontraks;

        if($request->hasFile('ktp')){
            $file1      = $request->file('ktp');
            $ktp  = rand(1,99999).$file1->getClientOriginalName();
            $extension = $file1->getClientOriginalExtension();
            $file1->move(public_path('documents/'),$ktp);

        }
        if($request->hasFile('kk')){
            $file2      = $request->file('kk');
            $kk  = rand(1,99999).$file2->getClientOriginalName();
            $extension = $file2->getClientOriginalExtension();
            $file2->move(public_path('documents/'),$kk);

        }
        if($request->hasFile('npwp')){
            $file3      = $request->file('npwp');
            $npwp  = rand(1,99999).$file3->getClientOriginalName();
            $extension = $file3->getClientOriginalExtension();
            $file3->move(public_path('documents/'),$npwp);
        }
        if($request->hasFile('foto')){
            $file4      = $request->file('foto');
            $foto  = rand(1,99999).$file4->getClientOriginalName();
            $extension = $file4->getClientOriginalExtension();
            $file4->move(public_path('documents/'),$foto);
        }
        if($request->hasFile('ijazah')){
            $file5      = $request->file('ijazah');
            $ijazah  = rand(1,99999).$file5->getClientOriginalName();
            $extension = $file5->getClientOriginalExtension();
            $file5->move(public_path('documents/'),$ijazah);
        }
        if($request->hasFile('kontrak')){
            $file6      = $request->file('kontrak');
            $kontrak  = rand(1,99999).$file6->getClientOriginalName();
            $extension = $file6->getClientOriginalExtension();
            $file6->move(public_path('documents/'),$kontrak);
        }
        $karyawan = Karyawan::find($id);
        $arr_documents = array(
            "document1"=>$ktp,
            "document2"=>$kk,
            "document3"=>$npwp,
            "document4"=>$foto,
            "document5"=>$ijazah,
            "document6"=>$kontrak,
        );
        $karyawan->documents = json_encode([$arr_documents]);
        $karyawan->save();
        return redirect()->back()->with(['success'=>'Documents  Berhasil Di Perbarui !']);
    }

    public function emp_attendance($id){
        $karyawan = Karyawan::find($id);
        $scheduleByEmployee = ScheduleAssignment::where('employee_id', $id)->get();
        $getShiftByEmployee = ScheduleAssignment::with('shift')->groupBy('shift_id')->get();
        $initial = AccountController::getinitialname(Auth::guard("emp")->user()->full_name);
        return view('karyawan.account.attendance.index',compact('initial','scheduleByEmployee','karyawan','getShiftByEmployee'));
    }
    public function emp_shift($id){
        $karyawan = Karyawan::find($id);
        $scheduleByEmployee = ScheduleAssignment::where('employee_id', $id)->get();
        $getShiftByEmployee = ScheduleAssignment::with('shift')->groupBy('shift_id')->get();
        $initial = AccountController::getinitialname(Auth::guard("emp")->user()->full_name);
        $requestShiftByEmployee = EmployeeRequestShift::where('employee_id',$id)->get();
        return view('karyawan.account.shift.index',compact('initial','scheduleByEmployee', 'getShiftByEmployee','karyawan','requestShiftByEmployee'));
    }
    public function emp_overtime($id){
        $karyawan = Karyawan::find($id);
        $initial = AccountController::getinitialname(Auth::guard("emp")->user()->full_name);
        return view('karyawan.account.overtime.index',compact('initial'));
    }
    public function emp_reimburstment($id){
        $karyawan = Karyawan::find($id);
        $initial = AccountController::getinitialname(Auth::guard("emp")->user()->full_name);
        return view('karyawan.account.reimburstment.index',compact('initial'));
    }

    public function requestShift(Request $request){
        $effectiveDate=Carbon::createFromFormat('d/m/Y', $request->effective_date)->format("Y-m-d");
        $shiftByEmployee = ScheduleAssignment::where('employee_id', $request->employee)->where('start_date','>=',$effectiveDate)->where('end_date','<=', $effectiveDate)->first();
        return $shiftByEmployee->shift->name." (in:".$shiftByEmployee->shift->working_hour_start." | out:".$shiftByEmployee->shift->working_hour_end.")";
    }

    public function emp_request_shift(Request $request){
        $validator = Validator::make($request->all(),[
            "effective_date" => "required",
            "current_shift" => "required",
            "new_shift" => "required",
            "notes" => "required"
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            return redirect()->back()->withInput()->withErrors($errors);
        }else{
            $requestShift = new EmployeeRequestShift();
            $requestShift->employee_id = $request->employee_id;
            $requestShift->effective_date = Carbon::createFromFormat('d/m/Y', $request->effective_date)->format("Y-m-d");
            $requestShift->current_shift = $request->current_shift;
            $requestShift->new_shift = $request->new_shift;
            $requestShift->notes = $request->notes;
            $requestShift->status = "PENDING";
            $requestShift->approval_by = 0;
            $requestShift->save();
            
            //get list employees as role spv to do send to group spv and head by department and organization
            $employeeHeadDivision = Employee::where('organization_id',$request->organization_id)->where('department_id',$request->department_id)->where('branch_id',$request->branch_id)->whereIn('job_level_id', [2,4])->get();  
           
            //insert into inbox to head division (supervisor and head)
            foreach($employeeHeadDivision as $employeeHead){
                //check if job level supervisor/head direct to hr
                if(Auth::guard("emp")->user()->id == $employeeHead->id){
                    $approvalLineId = Employee::find(Auth::guard("emp")->user()->id)->pluck('approval_line_id')->first();
                    $result = (new InboxController)->inboxMessage($requestShift->employee_id, $approvalLineId,"Change Shift ".Carbon::parse($requestShift->effective_date)->format("d F Y"),$requestShift->notes, "shift");
                }else{
                    $result = (new InboxController)->inboxMessage($requestShift->employee_id, $employeeHead->id,"Change Shift ".Carbon::parse($requestShift->effective_date)->format("d F Y"),$requestShift->notes, "shift");
                }
            }

            return redirect()->route('emp.account.shift', $request->employee_id);
        }
    }

    // public function timeoff($id){
    //     $karyawan = Employee::find($id);
    //     $timeoff = Timeoff::all();
    //     $employee = Employee::all();
    //     $cuti = LogTimeOffBalance::where('employee_id', $id)->where('timeoff_id', 1)->orderBy('id','desc')->first();
    //     $initial = AccountController::getinitialname(Auth::guard("emp")->user()->full_name);
    //     return view('karyawan.account.timeoff.index',compact('initial', 'employee', 'karyawan', 'timeoff','cuti'));
    // }

        /* Begin Timeoff  */
        public function timeoff($id)
        {
            $karyawan = Employee::find($id);
            $timeoff = Timeoff::all();
            $employee = Employee::all();
            $initial  = AccountController::getinitialname(Auth::guard("emp")->user()->full_name);
            $code = Timeoff::where('code', 'CT')->first();
            $cuti = LogTimeOffBalance::where('employee_id', Auth::guard('emp')->id())->where('timeoff_id', $code->id)->orderBy('id','desc')->first();
            // dd($initial);
            // dd(Auth::guard('emp')->user()->full_name);
            return view('karyawan.account.timeoff.index', compact('karyawan', 'initial', 'employee', 'timeoff', 'cuti'));
        }
    
        public function TimeOffStore(Request $request)
        { {
    
                $rules = [
                    "timeoff_id" => "required",
                    "start_date" => "required",
                    "end_date" => "required",
                    // "images" => "required|array",
                ];
    
                $validator = Validator::make($request->all(), $rules);
    
                if ($validator->fails()) {
                    return redirect()->back()->with(['warning' => $validator->errors()->first()])->withInput();
    
                    // return response()->json([
                    //     'status' => 400,
                    //     'message' => $validator->errors()->first()
                    // ]);
                } else {
    
                    //is valid timeoff_id?
                    $timeoff = Timeoff::where('id', $request->timeoff_id)->first();
    
                    if ($timeoff) {
    
                        //if time off izin, must be input request_type, schedule_in, schedule_out
                        if ($timeoff->code == 'I') {
    
                            $rules2 = [
                                "request_type" => "required|in:FULL_DAY,HALF_DAY_BEFORE_BREAK,HALF_DAY_AFTER_BREAK"
                            ];
    
                            $validator2 = Validator::make($request->all(), $rules2);
    
                            if ($validator2->fails()) {
                                return redirect()->back()->with(['warning' => $validator->errors()->first()])->withInput();
    
                                // return response()->json([
                                //     'status' => 400,
                                //     'message' => $validator2->errors()->first()
                                // ]);
                            } else {
    
                                if ($request->request_type == 'HALF_DAY_BEFORE_BREAK' || $request->request_type == 'HALF_DAY_AFTER_BREAK') {
    
                                    $rules3 = [
                                        "schedule_in" => "required",
                                        "schedule_out" => "required"
                                    ];
    
                                    $validator3 = Validator::make($request->all(), $rules3);
    
                                    if ($validator3->fails()) {
                                        return redirect()->back()->with(['warning' => $validator->errors()->first()])->withInput();
    
                                        // return response()->json([
                                        //     'status' => 400,
                                        //     'message' => $validator3->errors()->first()
                                        // ]);
                                    }
                                }
                            }
                        }
    
                        $quota_balance = 0;
                        $balance_start = 0;
                        $balance_end   = 0;
    
                        $sd = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
                        $ed = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
    
                        $start_date = Carbon::parse($sd);
                        $end_date   = Carbon::parse($ed);
    
    
                        $total_req_day = $start_date->diffInDays($end_date) + 1;
    
                        //if request type CT/Cuti Tahunan
                        if ($timeoff->code == 'CT') {
    
                            //check balance time off
                            $quota_balance = LogTimeOffBalance::where('employee_id', Auth::guard('emp')->id())->where('timeoff_id', $request->timeoff_id)->where('type', 'beginning_balance')->orderBy('created_at', 'desc')->first();
    
                            if ($quota_balance) {
                                if ($quota_balance->status == 1) {
                                    return redirect()->back()->with(['warning' => 'Your quota balance has been expired'])->withInput();
    
                                    // return response()->json([
                                    //     'status' => 200,
                                    //     'message' => 'Your quota balance has been expired'
                                    // ]);
    
                                }
    
                                //check last balance
                                $log_timeoff_balance = LogTimeOffBalance::where('employee_id', $request->user()->employee->id)->where('timeoff_id', $request->timeoff_id)->orderBy('created_at', 'desc')->first();
    
                                $balance_start = $log_timeoff_balance ? $log_timeoff_balance->ending_balance : ($quota_balance->ending_balance ?? 0);
    
                                $balance_end   = $balance_start - $total_req_day;
    
                                if ($balance_end < 0) {
    
                                    //quota balance has been exhausted
                                    return redirect()->back()->with(['warning' => 'Quota balance has been exhausted'])->withInput();
    
                                    // return response()->json([
                                    //     'status' => 400,
                                    //     'message' => 'Quota balance has been exhausted'
                                    // ]);
    
                                }
                            } else {
                                //quota balance not found
                                return redirect()->back()->with(['warning' => 'Quota balance not found'])->withInput();
    
                                // return response()->json([
                                //     'status' => 400,
                                //     'message' => 'Quota balance not found'
                                // ]);
                            }
                        }
    
                        //is exist?
    
                        // Upload to Firebase
    
                        $link = "https://firebasestorage.googleapis.com/v0/b";
                        $bucket_name = "payroll-f5ba7.appspot.com";
                        $firebase_storage_path2 = 'time_off';
    
                        $images = array();
    
                        $i = 0;
                        if ($files = $request->file('images')) {
                            foreach ($files as $key => $image) {
                                // $image = $request->file('images'); //image file from frontend  
                                $student   = app('firebase.firestore');
                                $firebase_storage_path = 'time_off/';
                                // $name     = $student->id();  
                                $localfolder = public_path('firebase-temp-uploads') . '/';
                                $extension = $image->getClientOriginalExtension();
                                $file      = "TO_WEB_" . Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Ymd') . "_" . Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Ymd') . "_ID" . Auth::guard("emp")->id() . "_" . $i++ . "." . $extension . "";
                                $images[] = $link . '/' . $bucket_name . '/o/' . $firebase_storage_path2 . '%2F' . $file . '?alt=media';
                                // time(). '.' . $extension;  
                                if ($image->move($localfolder, $file)) {
                                    $uploadedfile = fopen($localfolder . $file, 'r');
                                    app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . '' . $file]);
                                    //will remove from local laravel folder  
                                    unlink($localfolder . $file);
                                    echo 'success';
                                } else {
                                    echo 'error';
                                }
                            }
                        }
    
                        // END Upload to Firebase
                        $time_off_request = TimeoffBalance::select('*', DB::raw('(SELECT status FROM status_request_time_off WHERE time_off_balances_id = time_off_balances.id ORDER BY created_at DESC LIMIT 1) as status'))
                            ->where('employee_id', Auth::guard('emp')->id())
                            ->where('start_date', $request->start_date)
                            ->where('end_date', $request->end_date)
                            ->where('timeoff_id', $request->timeoff_id)
                            ->first();
    
                        if ($time_off_request) {
                            if ($time_off_request->status != 'APPROVED') {
                                return redirect()->back()->with(['warning' => 'You have applied before'])->withInput();
                                // return response()->json([
                                //     'status' => 400,
                                //     'message' => 'You have applied before'
                                // ]);
                            }
                        }
                        
                        //insert request time off
                        $insert = new TimeoffBalance();
                        $insert->employee_id = Auth::guard('emp')->id();
                        $insert->timeoff_id  = $request->timeoff_id;
                        $insert->start_date  = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
                        $insert->end_date    = Carbon::createFromFormat('d/m/Y', $request->end_date)->format("Y-m-d");
                        $insert->images      = json_encode($images);
                        $insert->note        = $request->notes;
                        $insert->balance_start = $balance_start;
                        $insert->balance_end   = $balance_end;
                        $insert->delegate      = $request->delegate;
    
                        if ($request->request_type) {
                            $insert->request_type = $request->request_type;
                            if ($request->request_type == 'HALF_DAY_BEFORE_BREAK' || $request->request_type == 'HALF_DAY_AFTER_BREAK') {
                                $insert->schedule_in  = $request->schedule_in;
                                $insert->schedule_out = $request->schedule_out;
                            }
                        }
    
                        $insert->save();
    
                        $req_id = $insert->id;
    
                        $insert_log = new StatusRequestTimeOff;
                        $insert_log->time_off_balances_id = $req_id;
                        $insert_log->status              = 'REQUEST';
                        $insert_log->description         = 'Waiting for approval';
                        $insert_log->save();
    
                        // insert log time off
                        $log_timeoff_balance = new LogTimeOffBalance();
                        $log_timeoff_balance->employee_id    = Auth::guard('emp')->id();
                        $log_timeoff_balance->transaction_id = $insert->id;
                        $log_timeoff_balance->timeoff_id     = $request->timeoff_id;
                        $log_timeoff_balance->type           = "time_off_taken";
                        $log_timeoff_balance->value          = -$total_req_day;
                        $log_timeoff_balance->ending_balance = $balance_end;
                        $log_timeoff_balance->status         = 0;
                        $insert->start_date                  = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
                        $insert->end_date                    = Carbon::createFromFormat('d/m/Y', $request->end_date)->format("Y-m-d");
                        $log_timeoff_balance->action         = "Time off Request";
                        $log_timeoff_balance->save();
    
                    $empFrom = Employee::where('id', $insert->employee_id)->first();
                    $cuti = Timeoff::where('id', $request->timeoff_id)->first();
                    // $empTo = Employee::where('id', $del->delegate_to)->first();
    
                    $employeeHeadDivision = Employee::where('id', $empFrom->id)->where('organization_id', $empFrom->organization_id)->where('department_id', $empFrom->department_id)->where('branch_id', $empFrom->branch_id)->whereIn('job_level_id', [2, 4])->get();
    
                    if ($request->job_level_id == 2 || $request->job_level_id == 4) {
    
                        // $statusDel = new StatusRequestDelegation();
                        // $statusDel->delegation_id = $del->id;
                        // $statusDel->approved_by = $employeeHeadDivision->approval_line_id;
                        // $statusDel->status = "PENDING";
    
                        // $statusDel->save();
    
                        $inbox = new Inbox();
                        $inbox->employee_id = $insert->employee_id;
                        $inbox->request_to = $employeeHeadDivision->approval_line_id;
                        $inbox->title = "Request $cuti->name ($total_req_day days) from $empFrom->full_name on $insert->start_date - $insert->end_date has been requested.";
                        $inbox->message = $request->notes;
                        $inbox->type = "timeoff";
    
                        $inbox->save();
    
                    } else {
    
                        //insert into inbox to head division (supervisor and head)
                        foreach ($employeeHeadDivision as $employeeHead) {
    
                            // $statusDel = new StatusRequestDelegation();
                            // $statusDel->delegation_id = $del->id;
                            // $statusDel->approved_by = $employeeHead->id;
                            // $statusDel->status = "PENDING";
    
                            // $statusDel->save();
                            $inbox = new Inbox();
                            $inbox->employee_id = $insert->employee_id;
                            $inbox->request_to = $employeeHead->id;
                            $inbox->title = "Request $cuti->name ($total_req_day days) from $empFrom->full_name on $insert->start_date - $insert->end_date has been requested.";
                            $inbox->message = $request->notes;
                            $inbox->type = "timeoff";
    
                            $inbox->save();
    
                        }
                    }
                        // return response()->json([
                        //     'status' => 200,
                        //     'message' => 'Request has been successfully'
                        // ]);
                        return redirect()->back()->with(['success' => 'Request has been successfully'])->withInput();
                    } else {
    
                        //timeoff_id invalid
                        return redirect()->back()->with(['danger' => 'timeoff_id invalid'])->withInput();
                        // return response()->json([
                        //     'status' => 400,
                        //     'message' => 'timeoff_id invalid'
                        // ]);
    
                    }
                }
            }
        }
    
    
        public function timeoffAjax(Request $request)
        {
            $columns = array('created_at', 'code', 'start_date', 'end_date', 'note', 'status', 'taken', 'cancel', 'detail', 'action');
    
            $total  = null;
            $boot   = null;
            $limit  = $request->input('length');
            $start  = $request->input('start');
            $order  = $columns[$request->input('order.0.column')];
            $dir  = $request->input('order.0.dir');
            $month = Carbon::now()->format('Y-m-d');
            if ($request->month) {
                $month = Carbon::createFromFormat('m/Y', $request->month)->format("Y-m-01");;
            }
            $startMonth = Carbon::parse($month)->startOfMonth()->format('Y-m-d') . ' 00:00:00';
            $endMonth = Carbon::parse($month)->endOfMonth()->format('Y-m-d') . ' 23:59:59';
    
            $temp = TimeoffBalance::join('status_request_time_off as b', 'time_off_balances.id', '=', 'b.time_off_balances_id')
                ->join('timeoffs as a', 'time_off_balances.timeoff_id', '=', 'a.id')
                ->where('time_off_balances.employee_id', Auth::guard("emp")->id())
                // ->groupBy('time_off_balances.id')
                ->select('time_off_balances.id', 'time_off_balances.employee_id', 'time_off_balances.timeoff_id', 'time_off_balances.start_date', 'time_off_balances.end_date', 'time_off_balances.request_type', 'time_off_balances.schedule_in', 'time_off_balances.schedule_out', 'time_off_balances.delegate', 'time_off_balances.balance_start', 'time_off_balances.balance_end', 'time_off_balances.note', 'time_off_balances.images', 'time_off_balances.created_at', 'time_off_balances.updated_at', 'a.code', 'a.name', 'b.status', 'b.description', 'b.approved_by', 'b.approval_date')
                ;
    
            if ($request->status) {
                $temp->where('b.status', $request->status);
            }
    
            if ($request->month) {
                $temp->whereDate('time_off_balances.created_at', '>=', $startMonth)->whereDate('time_off_balances.created_at', '<=', $endMonth);
            }
    
            $total = $temp->distinct()->count('time_off_balances.id');
            $totalFiltered = $total;
    
            if (empty($request->input('search.value'))) {
                $boot  = $temp
                    ->offset($start)
                    ->groupBy('time_off_balances.id')
                    ->orderBy($order, $dir)
                    ->limit($limit)
                    ->get();
            } else {
                $search = $request->input('search.value');
                $boot   = $temp
                    ->offset($start)
                    // ->where('time_off_balances.employee_id', Auth::user()->employee->id)
                    ->groupBy('time_off_balances.id')
                    ->whereRaw("(b.status) LIKE '%" . $search . "%' ")
                    ->orderBy($order, $dir)
                    ->limit($limit)
                    ->get();
            }
            // dd($boot->count());
            // $total = $boot->count();
            // $totalFiltered = $total;
    
            $data = array();
            if (!empty($boot)) {
                foreach ($boot as  $row) {
                    $st_timeoff = StatusRequestTimeOff::where('time_off_balances_id', $row->id)->get();
                    $app = StatusRequestTimeOff::where('time_off_balances_id', $row->id)->orderBy('id', 'DESC')->first();
                    $stdesc = StatusRequestTimeOff::where('time_off_balances_id', $row->id)->orderBy('status', 'DESC')->first();
    
                    // $cancel = StatusRequestTimeOff::where('time_off_balances_id', $row->id)->where('status', 'CANCELED')->first();
    
                    $start_date = Carbon::parse($row->start_date);
                    $end_date   = Carbon::parse($row->end_date);
    
                    $total_req_day = $start_date->diffInDays($end_date) + 1;
                    // dd($st_timeoff);
                    $obj['created_at'] = date("d/m/Y", strtotime($row->created_at));
                    $obj['code'] = $row->code;
                    $obj['start_date']  = date("d/m/Y", strtotime($row->start_date));
                    $obj['end_date']  = date("d/m/Y", strtotime($row->end_date));
                    if ($row->note) {
                        $obj['note'] = $row->note;
                    } else {
                        $obj['note'] = "-";
                    }
                    if ($app->status == 'APPROVED') {
                        $status = '<div class="text-success font-weight-bold">' . $app->status . '</div>';
                    } elseif ($app->status == 'PENDING' || $app->status == 'REQUEST') {
                        $status = '<div class="text-warning font-weight-bold">' . $app->status . '</div>';
                    } else {
                        $status = '<div class="text-danger font-weight-bold">' . $app->status . '</div>';
                    }
    
                    $obj['status'] = $status;
                    $obj['taken'] = $total_req_day;
    
                    if ($app->status == 'CANCELED') {
                        $cancel = '<div class="text-center"><i class="la la-check fa-lg text-danger"></i></div>';
                    } else {
                        $cancel = '-';
                    }
                    $obj['cancel'] = $cancel;
                    $obj['approval'] = '<div class="text-center"><a href="#" class="kt-link" data-toggle="modal" data-timeoff="' . $row->id . '" data-target="#kt_modal_8">View</a></div>';
                    $obj['detail'] = '<td class="text-center"><a href="#" class="kt-link" data-timeoff="' . $row->id . '" data-toggle="modal" data-target="#kt_modal_4"><i class="la la-file"></i> File</a></td>';
    
                    if ($app->status != 'REQUEST') {
                        $action = '<td><a type="button" href="javascript:;" class="btn-cancel btn btn-sm btn-clean btn-icon btn-icon-md disabled" title="Cancel" disabled>
                            <i class="la la-ban fa-lg text-danger"></i>
                        </a></td>';
                    } else {
                        $action = '<td><a type="button" href="javascript:;" id="cancelButton" class="btn-cancel btn btn-sm btn-clean btn-icon btn-icon-md" title="Cancel" data-id="' . $row->id . '" data-toggle="modal" data-target="#kt_modal_0">
                            <i class="la la-ban fa-lg text-danger"></i>
                        </a></td>';
                    }
    
    
                    $obj['action'] = $action;
    
    
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
    
        public function imgTimeOff($id)
        {
            $img = TimeoffBalance::find($id);
    
            return view('karyawan.account.timeoff.detail-img-timeoff', compact('img'));
        }
    
        public function timeoffCancel($id)
        {
            DB::beginTransaction();
            try {
    
                // dd(Auth::guard('emp')->user()->employee->full_name);
                $timeoff = new StatusRequestTimeOff();
                // $id = $id;
                $timeoff->time_off_balances_id = $id;
                $timeoff->description = "Has been canceled by " . Auth::guard('emp')->user()->full_name . "";
                $timeoff->approved_by = Auth::guard('emp')->id();
                $timeoff->status = "CANCELED";
                $timeoff->approval_date = Carbon::now();
    
                $timeoff->save();
                DB::commit();
                $message = ['status' => true, 'message' => 'Data Time Off Sukses diupdate !'];
                return response()->json($message, 200);
            } catch (\Exception $e) {
                DB::rollBack();
                $message = ['status' => false, 'message' => $e];
                return response()->json($message, 400);
            }
    
            // return redirect()->back()->with(['success'=>'Data Time Off berhasil dibatalkan']);
        }
    
        public function delegationCancel($id)
        {
            DB::beginTransaction();
            try {
    
    
                $timeoff = new StatusRequestDelegation();
                $id = $id;
                $timeoff->delegation_id = $id;
                $timeoff->description = "Has been canceled by " . Auth::guard('emp')->user()->full_name  . "";
                $timeoff->approved_by = Auth::guard('emp')->id();
                $timeoff->status = "CANCELED";
                $timeoff->approval_date = Carbon::now();
    
                $timeoff->save();
                DB::commit();
                $message = ['status' => true, 'message' => 'Data delegation berhasil dibatalkan !'];
                return response()->json($message, 200);
            } catch (\Exception $e) {
                DB::rollBack();
                $message = ['status' => false, 'message' => $e];
                return response()->json($message, 400);
            }
    
            // return redirect()->back()->with(['success'=>'Data Time Off berhasil dibatalkan']);
        }
    
    
        public function timeoffModal($id)
        {
            $status = StatusRequestTimeOff::join('employees', 'employees.id', '=', 'status_request_time_off.approved_by')
                ->select('status_request_time_off.*', 'employees.full_name', 'employees.employee_id')
                ->where('time_off_balances_id', $id)->get();
    
            return view('karyawan.account.timeoff.detail-timeoff', compact('status'));
        }
    
        public function timeoffTakenAjax(Request $request)
        {
            $columns = array('code', 'start_date', 'request_type');
    
            $total  = null;
            $boot   = null;
            $limit  = $request->input('length');
            $start  = $request->input('start');
            $order  = $columns[$request->input('order.0.column')];
            $dir  = $request->input('order.0.dir');
    
            $temp = StatusRequestTimeOff::join('time_off_balances as b', 'b.id', '=', 'status_request_time_off.time_off_balances_id')
                ->join('timeoffs as a', 'b.timeoff_id', '=', 'a.id')
                ->where('status_request_time_off.status', 'APPROVED')
                ->where('b.employee_id', Auth::guard("emp")->id())
                ->select('b.start_date', 'b.request_type', 'a.code', 'status_request_time_off.status');
    
            $total = $temp->count();
            $totalFiltered = $total;
    
            if (empty($request->input('search.value'))) {
                $boot  = $temp->offset($start)
                    
                    ->orderBy($order, $dir)
                    ->limit($limit)
                    ->get();
            } else {
                $search = $request->input('search.value');
                $boot   = $temp
                    ->offset($start)
                    
                    ->whereRaw("(b.start_date) LIKE '%" . $search . "%' ")
                    ->orderBy($order, $dir)
                    ->limit($limit)
                    ->get();
            }
    
            $data = array();
            if (!empty($boot)) {
                foreach ($boot as  $row) {
    
                    $request_type = str_replace("_", " ", $row->request_type);
                    // dd($st_timeoff);
                    $obj['code'] = "<div class='font-weight-bold'>$row->code</div>";
                    $obj['start_date'] = Carbon::createFromFormat('Y-m-d', $row->start_date)->format("l, d M Y");$row->start_date;
                    $obj['request_type']  = $request_type;
    
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
    
        public function delegateStore(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'delegateFrom' => 'required',
                'employee_id' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'notes' => 'required',
            ]);
    
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            } else {
                DB::beginTransaction();
                try {
    
                    $del = new Delegation();
                    $del->delegate_from = $request->delegateFrom;
                    $del->delegate_to = $request->employee_id;
                    $del->start_date = Carbon::createFromFormat('d/m/Y', $request->start_date)->format("Y-m-d");
                    $del->end_date = Carbon::createFromFormat('d/m/Y', $request->end_date)->format("Y-m-d");
                    $del->notes = $request->notes;
    
                    $del->save();
    
                    $empFrom = Employee::where('id', $del->delegate_from)->first();
                    $empTo = Employee::where('id', $del->delegate_to)->first();
    
                    $employeeHeadDivision = Employee::where('id', $empFrom->id)->where('organization_id', $empFrom->organization_id)->where('department_id', $empFrom->department_id)->where('branch_id', $empFrom->branch_id)->whereIn('job_level_id', [2, 4])->get();
    
                    if ($request->job_level_id == 2 || $request->job_level_id == 4) {
    
                        $statusDel = new StatusRequestDelegation();
                        $statusDel->delegation_id = $del->id;
                        $statusDel->approved_by = $employeeHeadDivision->approval_line_id;
                        $statusDel->status = "PENDING";
    
                        $statusDel->save();
    
                        $inbox = new Inbox();
                        $inbox->employee_id = $del->delegate_from;
                        $inbox->request_to = $del->delegate_to;
                        $inbox->title = "Delegation from $empFrom->full_name to $empTo->full_name on $del->start_date - $del->end_date";
                        $inbox->message = $del->notes;
                        $inbox->type = "timeoff";
    
                        $inbox->save();
    
                        $inbox2 = new Inbox();
                        $inbox2->employee_id = $del->delegate_from;
                        $inbox2->request_to = $employeeHeadDivision->approval_line_id;
                        $inbox2->title = "Delegation from $empFrom->full_name to $empTo->full_name on $del->start_date - $del->end_date";
                        $inbox2->message = $del->notes;
                        $inbox2->type = "timeoff";
    
                        $inbox2->save();
                    } else {
                        $inbox = new Inbox();
                        $inbox->employee_id = $del->delegate_from;
                        $inbox->request_to = $del->delegate_to;
                        $inbox->title = "Delegation from $empFrom->full_name to $empTo->full_name on $del->start_date - $del->end_date";
                        $inbox->message = $del->notes;
                        $inbox->type = "timeoff";
    
                        $inbox->save();
                        //insert into inbox to head division (supervisor and head)
                        foreach ($employeeHeadDivision as $employeeHead) {
    
                            $statusDel = new StatusRequestDelegation();
                            $statusDel->delegation_id = $del->id;
                            $statusDel->approved_by = $employeeHead->id;
                            $statusDel->status = "PENDING";
    
                            $statusDel->save();
    
                            $inbox2 = new Inbox();
                            $inbox2->employee_id = $del->delegate_from;
                            $inbox2->request_to = $employeeHead->id;
                            $inbox2->title = "Delegation from $empFrom->full_name to $empTo->full_name on $del->start_date - $del->end_date";
                            $inbox2->message = $del->notes;
                            $inbox2->type = "timeoff";
    
                            $inbox2->save();
                        }
                    }
    
                    DB::commit();
                    $message = ['status' => true, 'message' => 'Data Time Off Sukses diupdate !'];
                    return response()->json($message, 200);
                } catch (\Exception $e) {
                    DB::rollBack();
                    $message = ['status' => false, 'message' => $e];
                    return response()->json($message, 400);
                }
            }
        }
    
        public function delegationAjax(Request $request)
        {
            $column = array('full_name', 'crea', 'start_date', 'end_date', 'notes', 'status', 'detail', 'action');
    
            $total  = null;
            $boot   = null;
            $limit  = $request->input('length');
            $start  = $request->input('start');
            $order  = $column[$request->input('order.0.column')];
            $dir  = $request->input('order.0.dir');
    
            $temp = Delegation::join('status_request_delegations', 'status_request_delegations.delegation_id', '=', 'delegations.id')
                ->join('employees', 'employees.id', '=', 'delegations.delegate_to')
                ->select('delegations.*', 'delegations.created_at as crea', 'status_request_delegations.status', 'status_request_delegations.description', 'status_request_delegations.approved_by', 'status_request_delegations.approval_date', 'employees.full_name', 'employees.employee_id');
            
            $total = $temp->distinct()->count('delegations.id');
            $totalFiltered = $total;
    
            if ($request->status) {
                $temp->where('status_request_delegations.status', $request->status);
            }
    
            if (empty($request->input('search.value'))) {
                $boot  = $temp
                ->offset($start)
                    ->where('delegate_from', Auth::guard("emp")->id())
                    ->groupBy('delegations.id')
                    ->orderBy($order, $dir)
                    ->limit($limit)
                    ->get();
            } else {
                $search = $request->input('search.value');
                $boot   = $temp->whereRaw("(LOWER(employees.full_name) LIKE '%" . $search . "%')")
                    ->offset($start)
                    ->where('delegate_from', Auth::guard("emp")->user()->employee->id)
                    ->groupBy('delegations.id')
                    ->orderBy($order, $dir)
                    ->limit($limit)
                    ->get();
            }
    
    
            $data = array();
            if (!empty($boot)) {
                foreach ($boot as  $row) {
    
                    $app = StatusRequestDelegation::where('delegation_id', $row->id)->orderBy('id', 'DESC')->first();
    
                    $employee = '<div>' . $row->full_name . '<br><small>' . $row->employee_id . '</small></div>';
    
                    $obj['full_name'] = $employee;
                    $obj['crea'] = date("d/m/Y", strtotime($row->crea));
                    $obj['start_date'] = date("d/m/Y", strtotime($row->start_date));
                    $obj['end_date']  = date("d/m/Y", strtotime($row->end_date));
                    $obj['notes']  = "<div class='text-wrap'>" . $row->notes . "</div>";
                    if ($app->status == 'APPROVED') {
                        $status = '<div class="text-success font-weight-bold">' . $app->status . '</div>';
                    } elseif ($app->status == 'PENDING' || $app->status == 'REQUEST') {
                        $status = '<div class="text-warning font-weight-bold">' . $app->status . '</div>';
                    } else {
                        $status = '<div class="text-danger font-weight-bold">' . $app->status . '</div>';
                    }
    
                    $obj['status'] = $status;
                    // if ($row->status == 'APPROVED') {
                    //     $obj['status']  = '<td><span class="kt-badge kt-badge--success kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-success">Approved</span></td>';
                    // } elseif ($row->status == 'REJECTED' || $row->status == 'CANCELED') {
                    //     $obj['status']  = '<td><span class="kt-badge kt-badge--danger kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-danger">' . $row->status . '</span></td>';
                    // } else {
                    //     $obj['status']  = '<td><span class="kt-badge kt-badge--warning kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-warning">' . $row->status . '</span></td>';
                    // }
    
                    $obj['detail']  = '<a href="#" data-delegation="' . $row->id . '" class="kt-link" data-toggle="modal" data-target="#kt_modal_1">View</a>';
                    if ($app->status != 'REQUEST') {
                        $obj['action']  = '<a type="button" href="javascript:;" class="btn-cancel btn btn-sm btn-clean btn-icon btn-icon-md disabled" title="Cancel"><i class="la la-ban fa-lg text-danger"></i></a>';
                    } else {
                        $obj['action']  = '<a type="button" href="javascript:;" id="cancelButtonDelegation" class="btn-cancel btn btn-sm btn-clean btn-icon btn-icon-md" title="Cancel" data-id="' . $row->id . '" data-toggle="modal" data-target="#kt_modal_100"><i class="la la-ban fa-lg text-danger"></i></a>';
                    }
    
                    // $obj['action']  = '<a type="button" href="javascript:;" class="btn-cancel btn btn-sm btn-clean btn-icon btn-icon-md" title="Cancel"><i class="la la-ban fa-lg text-danger"></i></a>';
    
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
    
        public function delegationModal($delegation_id)
        {
            $status = StatusRequestDelegation::join('employees', 'employees.id', '=', 'status_request_delegations.approved_by')
                ->select('status_request_delegations.*', 'employees.full_name', 'employees.employee_id')
                ->where('delegation_id', $delegation_id)->get();
    
            return view('karyawan.account.timeoff.detail-delegation', compact('status'));
        }

        public function getEmp(Request $request){
            $search = $request->search;
    
            if($search == ''){
               $employees = Employee::leftjoin('job_position', 'employees.job_position_id','=','job_position.id')
               ->leftjoin('branches', 'employees.branch_id', '=', 'branches.id')
               ->orderBy('employees.full_name')
               ->select('employees.id', 'employees.employee_id', 'join_date', 'employees.full_name', 'job_position.name as jp_name', 'branches.name as b_name')->get();
            }else{
               $employees = Employee::leftjoin('job_position', 'employees.job_position_id','=','job_position.id')
               ->leftjoin('branches', 'employees.branch_id', '=', 'branches.id')
               ->orderBy('employees.full_name')
               ->select('employees.id', 'employees.employee_id', 'join_date', 'employees.full_name', 'job_position.name as jp_name', 'branches.name as b_name')->where('full_name', 'like', '%' .$search . '%')->get();
            }
    
            $response = array();
            foreach($employees as $employee){
               $response[] = array(
                    "id"=>$employee->id,
                    "text"=>$employee->full_name,
                    "employee_id"=>$employee->employee_id,
                    "jp_name"=>$employee->jp_name,
                    "join_date"=>$employee->join_date
               );
            }
            return response()->json($response);
         }
    
        /* End  Timeoff  */
}
