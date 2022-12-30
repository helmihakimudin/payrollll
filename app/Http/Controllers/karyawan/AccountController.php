<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Karyawan;
use App\Designation;
use App\Branch;
use App\JobPosition;
use DB;
use Validator;
use App\Education;
use App\Organization;
use App\EducationInformal;
use App\EducationWorking;
use App\FamilyEmployee;
use App\EmergengyEmployee;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

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
        $karyawan->req_date_of_birth    = date("Y-m-d",strtotime($request->date_of_birth));
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
}
