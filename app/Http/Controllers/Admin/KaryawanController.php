<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\ExportKaryawan;
use App\Employee;
use App\Imports\KaryawanImport;
use App\Organization;
use Illuminate\Support\Facades\Validator;

// use Validator;
// use DB;
use Illuminate\Support\Facades\Auth;
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
use App\Delegation;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Http\Controllers\AktivasiController;
use App\Inbox;
use App\Karyawan;
use App\LogTimeOffBalance;
use App\StatusRequestDelegation;
use App\StatusRequestTimeOff;
use App\Timeoff;
use App\TimeoffBalance;
use Illuminate\Support\Facades\Redirect;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\SignInResult\SignInResult;
use Kreait\Firebase\Exception\FirebaseException;
use Google\Cloud\Firestore\FirestoreClient;
use Session;
use Kreait\Firebase\Contract\Storage as StorageFB;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class KaryawanController extends Controller
{
    protected $db;
    public function __construct()
    {
        $this->db = app('firebase.firestore')->database();
    }
    public function index()
    {
        return view("admin.karyawan.index");
    }

    public function karyawanAjax(Request $request)
    {
        $column = array('full_name', 'employee_id', 'branch', 'organization', 'job_position', 'job_level', 'employee_status', 'join_date', 'end_date', 'end_date', 'email', 'date_of_birth', 'place_of_birth', 'residential_address', 'actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        $branch_id = $request->input('branch');
        $organization_id = $request->input('organization');
        $jobposition_id = $request->input('job_position');
        $joblevel_id = $request->input('job_level');

        $temp  = Employee::with('organization', 'branch', 'jobPosition', 'jobLevel');

        if (isset($branch_id) || isset($organization_id) || isset($jobposition_id) || isset($joblevel_id)) {
            $temp->where('employees.organization_id', $organization_id)->OrWhere('employees.branch_id', $branch_id)->Orwhere('employees.job_position_id', $jobposition_id)->OrWhere('employees.job_level_id', $joblevel_id);
        }

        $search = $request->input('search.value');
        if (isset($search)) {
            $temp->whereRaw("(LOWER(full_name) LIKE '%" . $search . "%' OR LOWER(email) LIKE '%" . $search . "%' OR LOWER(mobile_phone) LIKE '%" . $search . "%' OR LOWER(phone) LIKE '%" . $search . "%' OR LOWER(place_of_birth) LIKE '%" . $search . "%')");
        }

        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        } else {
            $search = $request->input('search.value');

            if (isset($branch_id) || isset($organization_id) || isset($jobposition_id) || isset($joblevel_id)) {
                $temp->where('employees.organization_id', $organization_id)->OrWhere('employees.branch_id', $branch_id)->Orwhere('employees.job_position_id', $jobposition_id)->OrWhere('employees.job_level_id', $joblevel_id);
            }

            $boot   = $temp->whereRaw("(LOWER(full_name) LIKE '%" . $search . "%' OR LOWER(email) LIKE '%" . $search . "%' OR LOWER(mobile_phone) LIKE '%" . $search . "%' OR LOWER(phone) LIKE '%" . $search . "%' OR LOWER(place_of_birth) LIKE '%" . $search . "%')")
                ->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        }
        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                if (isset($row->branch)) {
                    $branch = $row->branch->name;
                } else {
                    $branch = "-";
                }
                if (isset($row->organization)) {
                    $organization = $row->organization->name;
                } else {
                    $organization = "-";
                }
                if (isset($row->jobPosition->name)) {
                    $job_position = $row->jobPosition->name;
                } else {
                    $job_position = "-";
                }
                if (isset($row->jobLevel->name)) {
                    $job_level = $row->jobLevel->name;
                } else {
                    $job_level = "-";
                }
                $name = $row->full_name;
                $parts = explode(" ", $name);
                if (count($parts) > 1) {
                    $lastname = array_pop($parts);
                    $firstname = implode(" ", $parts);
                } else {
                    $firstname = $name;
                    $lastname = " ";
                }
                $inital = substr($firstname, 0, 1) . "" . substr($lastname, 0, 1);

                if ($row->avatar != null) {
                    $fullname = '<div class="kt-widget__item">
                                <span class="kt-media kt-media--circle">
                                    <img src="' . asset("demo10/assets/media/users/100_10.jpg") . '"alt="image">
                                </span>
                                <div class="kt-widget__info">
                                    <div class="kt-widget__section">
                                        <a href="#" class="kt-widget__username">' . $row->full_name . '</a>
                                        <span class="kt-badge kt-badge--success kt-badge--dot"></span>
                                    </div>
                                    <span class="kt-widget__desc">
                                        ' . $organization . '-' . $job_level . '-' . $job_position . '
                                    </span>
                                </div>
                            </div>';
                } else {
                    $fullname = '<div class="kt-widget__item">
                                    <span class="kt-media kt-media--circle">
                                        <div class="kt-widget__pic kt-widget__pic--info kt-font-info kt-font-boldest  kt-hidden-">' . $inital . '</div>
                                    </span>
                                    <div class="kt-widget__info">
                                        <div class="kt-widget__section">
                                            <a  href="' . route('employee.account', ['id' => $row->id]) . '"  class="kt-widget__username">' . $row->full_name . '</a>
                                            <span class="kt-badge kt-badge--success kt-badge--dot"></span>
                                        </div>
                                        <span class="kt-widget__desc">
                                            ' . $organization . '-' . $job_level . '-' . $job_position . '
                                        </span>
                                    </div>
                                </div>';
                }

                $edit     = '<a href="' . route('employee.account', ['id' => $row->id]) . '"  class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                                <i class="la la-eye"></i>
                            </a>';
                $hapus = '<a href="' . route('employee.destroy', ['id' => $row->id]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                <i class="la flaticon-delete"></i>
                            </a>';
                $obj['fullname']            = $fullname;
                $obj['employee_id']         = $row->employee_id;
                $obj['branch']              = $branch;
                $obj['job_position']        = $job_position;
                $obj['job_level']           = $job_level;
                $obj['employeement_status'] = $row->employeement_status;
                $obj['join_date']           = date("d M Y", strtotime($row->join_date));
                $obj['end_date']            = date("d M Y", strtotime($row->end_date));
                $obj['email']               = $row->email;
                $obj['date_of_birth']       = date("d M Y", strtotime($row->date_of_birth));
                $obj['place_of_birth']      = $row->place_of_birth;
                $obj['residential_address'] = "<div class='text-wrap'>" . $row->residential_address . "</div>";
                $obj['citizien_id_address'] = "<div class='text-wrap'>" . $row->citizien_id_address . "</div>";
                $obj['actions']             = $edit . " " . $hapus;
                $data[] = $obj;
            }
        }
        // dd($data);
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFiltered,
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function create()
    {
        return view('admin.karyawan.create');
    }

    public function getnamekaryawan($id)
    {
        $karyawan = Employee::find($id);
        return response()->json($karyawan);
    }

    public function updatecuti(request $request)
    {
        $id = $request->id;
        $karyawan = Employee::find($id);
        $karyawan->amount_paid_leave = $request->amount_paid_leave;
        $karyawan->save();
        return redirect()->back()->with(['succes' => $karyawan->name . " Berhasil Ditambahkan Cuti"]);
    }

    public function store(request $request)
    {
        $validator = Validator::make($request->all(), [
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|unique:employees",
            "mobile_phone" => "required",
            "phone" => "required",
            "place_of_birth" => "required",
            "date_of_birth" => "required",
            "gender" => "required",
            "marital_status" => "required",
            "blood_type" => "required",
            "religion" => "required",
            "identity_type" => "required",
            "identity_number" => "required",
            "expired_identity" => "required",
            "postal_code" => "required",
            "citizien_id_address" => "required",
            "residential_address" => "required",
            "employee_id" => "required",
            "barcode" => "required",
            "employee_status" => "required",
            "join_date" => "required",
            "end_date" => "required",
            "branch_id" => "required",
            "organization_id" => "required",
            "job_position_id" => "required",
            "job_level_id" => "required",
            "approval_line_id" => "required",
            "basic_salary" => "required",
            "salary_type" => "required",
            "payment_schedule" => "required",
            "preorate_setting" => "required",
            "cost_center_category" => "required",
            "allowance_overtime" => "required",
            "bank_name" => "required",
            "account_holder_name" => "required",
            "account_number" => "required",
            "npwp" => "required",
            "ptkp_status" => "required",
            "tax_method" => "required",
            "tax_salary" => "required",
            "taxable_date" => "required",
            "employeement_tax_status" => "required",
            "netto" => "required",
            "pph21" => "required",
            "bpjs_kerja_number" => "required",
            "bpjs_kerja_date" => "required",
            "bpjs_kesehatan_number" => "required",
            "bpjs_kesehatan_family" => "required",
            "bpjs_kesehatan_date" => "required",
            "bpjs_kesehatan_cost" => "required",
            "bpjs_jht_cost" => "required",
            "jaminan_pensiun_cost" => "required",
            "jaminan_pensiun_date" => "required",
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withInput()->withErrors($errors);
        } else {
            $employee = new Employee;
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->email = $request->email;
            $employee->full_name = $request->first_name . " " . $request->last_name;
            $employee->password = "duasisi123";
            $employee->employeement_status = "Contract";
            $employee->mobile_phone = $request->mobile_phone;
            $employee->phone = $request->phone;
            $employee->place_of_birth = $request->place_of_birth;
            $employee->date_of_birth = Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->format("Y-m-d");
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
            $employee->company_doj = Carbon::createFromFormat('d/m/Y', $request->join_date)->format("Y-m-d");
            $employee->join_date = Carbon::createFromFormat('d/m/Y', $request->join_date)->format("Y-m-d");
            $employee->end_date = Carbon::createFromFormat('d/m/Y', $request->end_date)->format("Y-m-d");
            $employee->branch_id = $request->branch_id;
            $employee->department_id = $request->department_id;
            $employee->organization_id = $request->organization_id;
            $employee->job_position_id = $request->job_position_id;
            $employee->job_level_id = $request->job_level_id;
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
            $employee->bpjs_kerja_date = Carbon::createFromFormat('d/m/Y', $request->bpjs_kerja_date)->format("Y-m-d");
            $employee->bpjs_kesehatan_number = $request->bpjs_kesehatan_number;
            $employee->bpjs_kesehatan_family = $request->bpjs_kesehatan_family;
            $employee->bpjs_kesehatan_date = Carbon::createFromFormat('d/m/Y', $request->bpjs_kesehatan_date)->format("Y-m-d");
            $employee->bpjs_kesehatan_cost = $request->bpjs_kesehatan_cost;
            $employee->bpjs_jht_cost = $request->bpjs_jht_cost;
            $employee->jaminan_pensiun_cost = $request->jaminan_pensiun_cost;
            $employee->jaminan_pensiun_date = Carbon::createFromFormat('d/m/Y', $request->jaminan_pensiun_date)->format("Y-m-d");
            $employee->created_by = Auth::user()->id;
            $employee->save();

            //send email invitation
            $result = (new AktivasiController)->sendEmailToUser($employee->id);

            // return redirect()->route('employee')->with(['success'=>'Karyawan Sukses dibuat !']);
        }
    }

    public function nonaktif(request $request)
    {
        $old = Employee::find($request->id1);
        $old->employee_status   = $request->old1;
        $old->reason            = $request->reason1;
        if ($request->reason1 == "Mutasi") {
            $karyawan = new Karyawan();
            $karyawan->user_id              = Auth::user()->id;
            $karyawan->id_card              = $request->id_card1;
            $karyawan->name                 = $request->name1;
            $karyawan->dob                  = date("Y-m-d", strtotime($request->dob1));
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
            $karyawan->company_doj          = date("Y-m-d", strtotime($request->company_doj1));
            $karyawan->start_date           = date("Y-m-d", strtotime($request->start_date1));
            $karyawan->end_date             = date("Y-m-d", strtotime($request->end_date1));
            $karyawan->account_holder_name  = $request->account_holder_name1;
            $karyawan->account_number       = $request->account_number1;
            $karyawan->bank_name            = $request->bank_name1;
            $karyawan->tax_payer_id         = $request->tax_payer_id1;
            $karyawan->documents            = $request->documents1;
            $karyawan->created_by           = Auth::user()->id;
            $karyawan->save();
        }
        $old->end_date          = date('Y-m-d', strtotime($request->end_date1));
        $old->save();
        return redirect()->back()->with(['success' => 'Karyawan Sukses dinonaktifkan !']);
    }


    public static function getinitialname($names)
    {
        $name = $names;
        $parts = explode(" ", $name);
        if (count($parts) > 1) {
            $lastname = array_pop($parts);
            $firstname = implode(" ", $parts);
        } else {
            $firstname = $name;
            $lastname = " ";
        }
        $inital = substr($firstname, 0, 1) . "" . substr($lastname, 0, 1);
        return $inital;
    }

    public static function getAgeEmployee($age)
    {
        $dateOfBirth = date("Y-m-d", strtotime($age));
        $today = date("Y-m-d");
        $diff  = date_diff(date_create($dateOfBirth), date_create($today));
        $age   = $diff->format('%y');
        return $age;
    }

    /* Begin Personal  */
    public function account($id)
    {
        $karyawan = Employee::find($id);
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        $age      = KaryawanController::getAgeEmployee($karyawan->date_of_birth);
        return view('admin.karyawan.account.personal.index', compact('karyawan', 'initial', 'age'));
    }

    public function identity($id)
    {
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.personal.index', compact('karyawan'));
    }

    public function family_ajax(request $request)
    {
        $id = $request->id;
        $column = array('name', 'relationship', 'birthdate', 'marital_status', 'job', 'religion', 'actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = DB::table('family_employee')->select('id', 'name', 'relationship', 'birthdate', 'marital_status', 'gender', 'job', 'religion', 'id as actions')
            ->where('employee_id', $id);
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        } else {
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(name) LIKE '%" . $search . "%' OR LOWER(relationship) LIKE '%" . $search . "%' OR LOWER(marital_status) LIKE '%" . $search . "%' OR LOWER(gender) LIKE '%" . $search . "%' OR LOWER(job) LIKE '%" . $search . "%' OR LOWER(religion) LIKE '%" . $search . "%')")
                ->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $edit = '<a href="javascript:;" data-attr="' . route('employee.account.personal.family.edit', ['id' => $row->id]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-family" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus = '<a  href="javascript:;" data-attr="' . route('employee.account.personal.family.show', ['id' => $row->id]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-family" title="Delete">
                            <i class="la flaticon-delete"></i>
                        </a>';
                $obj['name']            = $row->name;
                $obj['relationship']    = $row->relationship;
                $obj['birthdate']       = $row->birthdate;
                $obj['marital_status']  = $row->marital_status;
                $obj['gender']          = $row->gender;
                $obj['job']             = $row->job;
                $obj['religion']        = $row->religion;
                $obj['actions']         = $edit . '' . $hapus;
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

    public function family_create($id)
    {
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.personal.create-family', compact('karyawan'));
    }

    public function family_store(request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'relationship' => 'required',
            'birthdate' => 'required',
            'marital_status' => 'required',
            'gender' => 'required',
            'job' => 'required',
            'religion' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['error' => 'Required Field!']);
        } else {
            $family = new FamilyEmployee;
            $family->name = $request->name;
            $family->employee_id = $id;
            $family->relationship = $request->relationship;
            $family->birthdate = date("Y-m-d", strtotime($request->birthdate));
            $family->marital_status = $request->marital_status;
            $family->gender = $request->gender;
            $family->job = $request->job;
            $family->religion = $request->religion;
            $family->save();
        }
        return redirect()->back()->with(['success' => 'Family Employee Success Created !']);
    }

    public function family_edit($id)
    {
        $family = FamilyEmployee::find($id);
        return view('admin.karyawan.account.personal.edit-family', compact('family'));
    }


    public function personal_request_edit($id)
    {
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.personal.edit.personal', compact('karyawan'));
    }


    public function personal_request_update(request $request, $id)
    {

        $karyawan = Employee::find($id);
        $karyawan->first_name           = $request->req_first_name;
        $karyawan->last_name            = $request->req_last_name;
        $karyawan->full_name            = $request->req_first_name . " " . $request->req_last_name;
        $karyawan->mobile_phone         = $request->req_mobile_phone;
        $karyawan->phone                = $request->req_phone;
        $karyawan->email                = $request->req_email;
        $karyawan->place_of_birth       = $request->req_place_of_birth;
        $karyawan->date_of_birth        = date("Y-m-d", strtotime($request->req_date_of_birth));
        $karyawan->blood_type           = $request->req_blood_type;
        $karyawan->marital_status       = $request->req_marital_status;
        $karyawan->religion             = $request->req_religion;
        $karyawan->is_req_personal      = 0;
        $karyawan->save();
        if ($karyawan->is_req_personal == 0) {

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
        return redirect()->back()->with(['success' => 'Request Approvement!']);
    }

    public function identity_request_edit($id)
    {
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.personal.edit.identity', compact('karyawan'));
    }

    public function identity_request_update(request $request, $id)
    {
        $karyawan = Employee::find($id);
        $karyawan->identity_type    = $request->req_identity_type;
        $karyawan->identity_number  = $request->req_identity_number;
        $karyawan->postal_code      = $request->req_postal_code;
        $karyawan->citizien_id_address = $request->req_citizien_id_address;
        $karyawan->residential_address = $request->req_residential_address;
        $karyawan->is_req_identity     = 0;
        $karyawan->save();
        if ($karyawan->is_req_identity == 0) {

            $karyawan = Employee::find($id);
            $karyawan->req_identity_type   = null;
            $karyawan->req_identity_number = null;
            $karyawan->req_postal_code     = null;
            $karyawan->req_citizien_id_address = null;
            $karyawan->req_residential_address = null;
            $karyawan->save();
        }
        return redirect()->back()->with(['success' => 'Request Approvement!']);
    }

    public function family_update(request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'relationship' => 'required',
            'birthdate' => 'required',
            'marital_status' => 'required',
            'gender' => 'required',
            'job' => 'required',
            'religion' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['error' => 'Required Field!']);
        } else {
            $family = FamilyEmployee::find($id);
            $family->name = $request->name;
            $family->relationship = $request->relationship;
            $family->birthdate = date("Y-m-d", strtotime($request->birthdate));
            $family->marital_status = $request->marital_status;
            $family->gender = $request->gender;
            $family->job = $request->job;
            $family->religion = $request->religion;
            $family->save();
        }
        return redirect()->back()->with(['success' => 'Family Employee Success Update !']);
    }

    public function family_request_update(request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'relationship' => 'required',
            'birthdate' => 'required',
            'marital_status' => 'required',
            'gender' => 'required',
            'job' => 'required',
            'religion' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['error' => 'Required Field!']);
        } else {
            $family = FamilyEmployee::find($id);
            $family->name = $request->name;
            $family->relationship = $request->relationship;
            $family->birthdate = date("Y-m-d", strtotime($request->birthdate));
            $family->marital_status = $request->marital_status;
            $family->gender = $request->gender;
            $family->job = $request->job;
            $family->religion = $request->religion;
            $family->save();
        }
        return redirect()->back()->with(['success' => 'Family Employee Success Update !']);
    }

    public function family_show($id)
    {
        $family = FamilyEmployee::find($id);
        return view('admin.karyawan.account.personal.show-family', compact('family'));
    }

    public function family_delete($id)
    {
        $family = FamilyEmployee::find($id);
        $family->delete();
        return redirect()->back()->with(['success' => 'Family Employee Success Deleted !']);
    }

    public function emergency_ajax(request $request)
    {
        $id = $request->id;
        $column = array('name', 'relationship', 'phone_number', 'actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = EmergengyEmployee::select('id', 'name', 'relationship', 'phone_number', 'id as actions')
            ->where('employee_id', $id);
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        } else {
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(name) LIKE '%" . $search . "%' OR LOWER(relationship) LIKE '%" . $search . "%' OR LOWER(phone_number) LIKE '%" . $search . "%')")
                ->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $edit = '<a href="javascript:;" data-attr="' . route('employee.account.personal.emergency.edit', ['id' => $row->id]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-emergency" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus = '<a  href="javascript:;" data-attr="' . route('employee.account.personal.emergency.show', ['id' => $row->id]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-emergency" title="Delete">
                            <i class="la flaticon-delete"></i>
                        </a>';
                $obj['name']            = $row->name;
                $obj['relationship']    = $row->relationship;
                $obj['phone_number']    = $row->phone_number;
                $obj['actions']         = $edit . '' . $hapus;
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

    public function emergency_create($id)
    {
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.personal.create-emergency', compact('karyawan'));
    }

    public function emergency_store(request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'relationship' => 'required',
            'phone_number' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['error' => 'Required Field!']);
        } else {
            $emergency = new EmergengyEmployee;
            $emergency->name = $request->name;
            $emergency->employee_id = $id;
            $emergency->relationship = $request->relationship;
            $emergency->phone_number = $request->phone_number;
            $emergency->save();
        }
        return redirect()->back()->with(['success' => 'Emergency Employee Success Created !']);
    }

    public function emergency_edit($id)
    {
        $emergency = EmergengyEmployee::find($id);
        return view('admin.karyawan.account.personal.edit-emergency', compact('emergency'));
    }

    public function emergency_update(request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'relationship' => 'required',
            'phone_number' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['error' => 'Required Field!']);
        } else {
            $emergency = EmergengyEmployee::find($id);
            $emergency->name = $request->name;
            $emergency->relationship = $request->relationship;
            $emergency->phone_number = $request->phone_number;
            $emergency->save();
        }
        return redirect()->back()->with(['success' => 'Emergency Employee Success Update !']);
    }

    public function emergency_show($id)
    {
        $emergency = EmergengyEmployee::find($id);
        return view('admin.karyawan.account.personal.show-emergency', compact('emergency'));
    }

    public function emergency_delete($id)
    {
        $emergency = EmergengyEmployee::find($id);
        $emergency->delete();
        return redirect()->back()->with(['success' => 'Emergency Employee Success Deleted !']);
    }
    /* End Personal  */


    /* Begin Employement Data  */
    public function employementdata($id)
    {
        // $karyawan = Employee::leftjoin('branches','employees.branch_id','=','branches.id')
        //                     ->leftjoin('departments','employees.department_id','=','departments.id')
        //                     ->leftjoin("job_position",'employees.job_position_id','=','job_position.id')
        //                     ->leftjoin("job_level",'employees.job_level_id','=','job_level.id')
        $karyawan = Employee::with('branch', 'department', "jobPosition", "jobLevel")
            ->where('employees.id', $id)->first();
        $organization = Organization::select('name', 'id')->where('id', $karyawan->organization_id)->first();
        $relatebranch = Employee::leftjoin('branches', 'employees.branch_id', '=', 'branches.id')
            ->leftjoin('departments', 'employees.branch_id', '=', 'branches.id')
            ->leftjoin("job_position", 'employees.job_position_id', '=', 'job_position.id')
            ->select("employees.*", 'job_position.name as jobposition', 'branches.name as branch')
            ->where("organization_id", $organization->id)
            ->where("employee_status", "Aktif")
            ->get();
        $initial = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.employeement-data.index', compact('karyawan', 'initial', 'relatebranch'));
    }

    //Update Employment Data
    public function employementUpdate(Request $request, $id)
    {
        $employee = Employee::find($id);
        $employee->employee_id = $request->employee_id;
        $employee->barcode = $request->barcode;
        $employee->employeement_status = $request->employeement_status;
        $employee->organization_id = $request->organization_id;
        $employee->branch_id = $request->branch_id;
        $employee->department_id = $request->department_id;
        $employee->join_date =  Carbon::createFromFormat('d/m/Y', $request->join_date)->format("Y-m-d");
        $employee->end_date =  Carbon::createFromFormat('d/m/Y', $request->end_date)->format("Y-m-d");
        $employee->job_position_id = $request->job_position_id;
        $employee->job_level_id = $request->job_level_id;
        $employee->approval_line_id = $request->approval_line_id;
        $employee->save();

        return redirect()->back()->with(['success' => 'Data Employee has been updated !']);
    }

    /* End Employement Data  */


    /* Begin education */
    public function education($id)
    {
        $karyawan = Employee::find($id);
        $initial = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.education.index', compact('karyawan', 'initial'));
    }

    public function educationformalajax(request $request)
    {
        $id = $request->id;
        $column = array('grade', 'institute_name', 'major', 'start_year', 'end_year', 'score', 'actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = DB::table('education')->select('id', 'grade', 'institute_name', 'major', 'start_year', 'end_year', 'score', 'id as actions')
            ->where('employee_id', $id);
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        } else {
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(grade) LIKE '%" . $search . "%' OR LOWER(institute_name) LIKE '%" . $search . "%' OR LOWER(major) LIKE '%" . $search . "%')")
                ->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $edit = '<a href="javascript:;" data-attr="' . route('employee.account.education.edit', ['id' => $row->id]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-education" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus = '<a  href="javascript:;" data-attr="' . route('employee.account.education.show', ['id' => $row->id]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-education" title="Delete">
                            <i class="la flaticon-delete"></i>
                        </a>';
                $obj['grade']             = $row->grade;
                $obj['institute_name']    = $row->institute_name;
                $obj['major']             = $row->major;
                $obj['start_year']        = $row->start_year;
                $obj['end_year']          = $row->end_year;
                $obj['score']             = $row->score;
                $obj['actions']           = $edit . '' . $hapus;
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

    public function create_education($id)
    {
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.education.create-formal', compact("karyawan"));
    }

    public function store_education(request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'grade' => 'required',
            'institute_name' => 'required',
            'major' => 'required',
            'score' => 'required',
            'start_year' => 'required',
            'end_year' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['error' => 'Required Field!']);
        } else {
            $education = new Education;
            $education->employee_id = $id;
            $education->grade = $request->grade;
            $education->institute_name = $request->institute_name;
            $education->major = $request->major;
            $education->score = $request->score;
            $education->start_year = $request->start_year;
            $education->end_year = $request->end_year;
            $education->save();
            return redirect()->back()->with(['success' => 'Your Education Successfull Created !']);
        }
    }

    public function edit_education($id)
    {
        $education = Education::find($id);
        return view('admin.karyawan.account.education.edit-formal', compact('education'));
    }

    public function update_education(request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'grade' => 'required',
            'institute_name' => 'required',
            'major' => 'required',
            'score' => 'required',
            'start_year' => 'required',
            'end_year' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['error' => 'Required Field!']);
        } else {
            $education = Education::find($id);
            $education->grade = $request->grade;
            $education->institute_name = $request->institute_name;
            $education->major = $request->major;
            $education->score = $request->score;
            $education->start_year = $request->start_year;
            $education->end_year = $request->end_year;
            $education->save();
            return redirect()->back()->with(['success' => 'Your Education Successfull Updated !']);
        }
    }

    public function show_education($id)
    {
        $education = Education::find($id);
        return view('admin.karyawan.account.education.show-education', compact('education'));
    }

    public function delete_education($id)
    {
        $education = Education::find($id);
        $education->delete();
        return redirect()->back()->with(['success' => 'Your Education Successfull Delete !']);
    }

    public function educationinformalajax(request $request)
    {
        $id = $request->id;
        $column = array("name", "held_by", "start_date", "end_date", "duration", "fee", "certificate", "actions");
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = DB::table('education_informal')->select('id', 'name', 'held_by', 'start_date', 'end_date', 'duration', 'dayshour', 'fee', "certificate", 'id as actions')
            ->where('employee_id', $id);
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        } else {
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(name) LIKE '%" . $search . "%' OR LOWER(held_by) LIKE '%" . $search . "%')")
                ->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $edit = '<a href="javascript:;" data-attr="' . route('employee.account.education.informal.edit', ['id' => $row->id]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-education-informal" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus = '<a  href="javascript:;" data-attr="' . route('employee.account.education.informal.show', ['id' => $row->id]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-education-informal" title="Delete">
                            <i class="la flaticon-delete"></i>
                        </a>';
                if ($row->certificate != null) {
                    $certificate = '<a href="' . asset('storage/certificate/' . $row->certificate) . '"  target="_blank"  class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View Certificate">
                                        <i class="la flaticon-file"></i>
                                    </a>';
                } else {
                    $certificate  = "No";
                }
                $obj['name']        = $row->name;
                $obj['held_by']     = $row->held_by;
                $obj['start_date']  = date("d M Y", strtotime($row->start_date));
                $obj['end_date']    = date("d M Y", strtotime($row->end_date));
                $obj['duration']    = $row->dayshour . " " . $row->duration;
                $obj['fee']         = $row->fee;
                $obj['certificate'] = $certificate;
                $obj['actions']     = $edit . '' . $hapus;
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

    public function create_education_informal($id)
    {
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.education.create-informal', compact('karyawan'));
    }

    public function store_informal_education(request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'held_by' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'duration' => 'required',
            'dayshour' => 'required',
            'expired_date' => 'required',
            'fee' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['error' => 'Required Field!']);
        } else {
            if ($request->hasFile('certificate')) {
                $filenameWithExt = $request->file('certificate')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('certificate')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $path = $request->file('certificate')->storeAs('public/certificate', $fileNameToStore);
            } else {
                $fileNameToStore = "No";
            }
            $education = new EducationInformal;
            $education->employee_id = $id;
            $education->name = $request->name;
            $education->held_by = $request->held_by;
            $education->start_date      = date('Y-m-d', strtotime($request->start_date));
            $education->end_date        = date('Y-m-d', strtotime($request->end_date));
            $education->duration        = $request->duration;
            $education->dayshour        = $request->dayshour;
            $education->expired_date    = date('Y-m-d', strtotime($request->expired_date));
            $education->fee = $request->fee;
            $education->certificate = $fileNameToStore;
            $education->save();
            return redirect()->back()->with(['success' => 'Your Education Informal Successfull Update !']);
        }
    }

    public function edit_education_informal($id)
    {
        $education = EducationInformal::find($id);
        return view('admin.karyawan.account.education.edit-informal', compact('education'));
    }

    public function update_education_informal(request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'held_by' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'duration' => 'required',
            'dayshour' => 'required',
            'expired_date' => 'required',
            'fee' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['error' => 'Required Field!']);
        } else {
            $education = EducationInformal::find($id);
            if ($request->hasFile('certificate')) {
                $filenameWithExt = $request->file('certificate')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('certificate')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $path = $request->file('avatar')->storeAs('public/avatars', $fileNameToStore);
            } else {
                $fileNameToStore = $education->certificate;
            }
            $education->name            = $request->name;
            $education->held_by         = $request->held_by;
            $education->start_date      = date('Y-m-d', strtotime($request->start_date));
            $education->end_date        = date('Y-m-d', strtotime($request->end_date));
            $education->duration        = $request->duration;
            $education->dayshour        = $request->dayshour;
            $education->expired_date    = date('Y-m-d', strtotime($request->expired_date));
            $education->fee             = $request->fee;
            $education->certificate     = $fileNameToStore;
            $education->save();
            return redirect()->back()->with(['success' => 'Your Education informal Successfull Updated !']);
        }
    }

    public function show_education_informal($id)
    {
        $education = EducationInformal::find($id);
        return view('admin.karyawan.account.education.show-education-informal', compact('education'));
    }

    public function delete_education_informal($id)
    {
        $education = EducationInformal::find($id);
        $path = '/public/certificate/' . $education->certificate;
        Storage::delete($path);
        if (!Storage::exists($path)) {
            $education->delete();
        }
        return redirect()->back()->with(['success' => 'Your Education informal Successfull Deleted !']);
    }

    public function educationworkingajax(request $request)
    {
        $id = $request->id;
        $column = array("company", "position", "froms", "tos", "length", "actions");
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = DB::table('education_working')->select('id', 'company', 'position', 'froms', 'tos', 'id as actions')
            ->where('employee_id', $id);
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        } else {
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(company) LIKE '%" . $search . "%' OR LOWER(position) LIKE '%" . $search . "%')")
                ->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $date1 = date("Y-m-d", strtotime($row->froms));
                $date2 = date("Y-m-d", strtotime($row->tos));
                $diff = abs(strtotime($date2) - strtotime($date1));
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

                $merge = $years . " Year " . $months . " Month " . $days . " days";

                $edit = '<a href="javascript:;" data-attr="' . route('employee.account.education.working.edit', ['id' => $row->id]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-education-working" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus = '<a  href="javascript:;" data-attr="' . route('employee.account.education.working.show', ['id' => $row->id]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-education-working" title="Delete">
                            <i class="la flaticon-delete"></i>
                        </a>';
                $obj['company']         = $row->company;
                $obj['position']        = $row->position;
                $obj['froms']           = date("d M Y", strtotime($row->froms));
                $obj['tos']             = date("d M Y", strtotime($row->tos));
                $obj['length']          = $merge;
                $obj['actions']         = $edit . '' . $hapus;
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

    public function create_education_working($id)
    {
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.education.create-working', compact('karyawan'));
    }

    public function store_education_working(request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'company' => 'required',
            'position' => 'required',
            'froms' => 'required',
            'tos' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['error' => 'Required Field!']);
        } else {
            $education = new EducationWorking;
            $education->employee_id  = $id;
            $education->company      = $request->company;
            $education->position     = $request->position;
            $education->froms        = date('Y-m-d', strtotime($request->froms));
            $education->tos          = date('Y-m-d', strtotime($request->tos));
            $education->save();
            return redirect()->back()->with(['success' => 'Your Education informal Successfull Created !']);
        }
    }

    public function edit_education_working($id)
    {
        $education = EducationWorking::find($id);
        return view('admin.karyawan.account.education.edit-working', compact('education'));
    }

    public function update_education_working(request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'company' => 'required',
            'position' => 'required',
            'froms' => 'required',
            'tos' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['error' => 'Required Field!']);
        } else {
            $education = EducationWorking::find($id);
            $education->company      = $request->company;
            $education->position     = $request->position;
            $education->froms        = date('Y-m-d', strtotime($request->froms));
            $education->tos          = date('Y-m-d', strtotime($request->tos));
            $education->save();
            return redirect()->back()->with(['success' => 'Your Education Working Successfull Updated !']);
        }
    }

    public function show_education_working($id)
    {
        $education = EducationWorking::find($id);
        return view('admin.karyawan.account.education.show-working', compact('education'));
    }

    public function delete_education_working($id)
    {
        $education = EducationWorking::find($id);
        $education->delete();
        return redirect()->back()->with(['success' => 'Your Education Working Successfull Deleted !']);
    }
    /* End  education  */

    /* Begin  attendance  */
    public function attendance($id)
    {
        $karyawan = Employee::find($id);
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.attendance.index', compact('karyawan', 'initial'));
    }
    /* End  attendance  */

    /* Begin shift  */
    public function shift($id)
    {
        $karyawan = Employee::find($id);
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.shift.index', compact('karyawan', 'initial'));
    }
    /* End shift  */

    /* Begin Timeoff  */
    public function timeoff($id)
    {
        $karyawan = Employee::find($id);
        $timeoff = Timeoff::all();
        $employee = Employee::all();
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        $cuti = LogTimeOffBalance::where('employee_id', $id)->where('timeoff_id', 1)->orderBy('id','desc')->first();

        return view('admin.karyawan.account.timeoff.index', compact('karyawan', 'initial', 'employee', 'timeoff', 'cuti'));
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
                        $quota_balance = LogTimeOffBalance::where('employee_id', $request->user()->employee->id)->where('timeoff_id', $request->timeoff_id)->where('type', 'beginning_balance')->orderBy('created_at', 'desc')->first();

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
                            $file      = "TO_WEB_" . Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Ymd') . "_" . Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Ymd') . "_ID" . Auth::id() . "_" . $i++ . "." . $extension . "";
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
                        ->where('employee_id', $request->user()->employee->id)
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
                    $insert->employee_id = $request->user()->employee->id;
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
                    $log_timeoff_balance->employee_id    = $request->user()->employee->id;
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
            ->where('time_off_balances.employee_id', Auth::user()->employee->id)
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
        $imgs = json_decode($img->images);

        return view('admin.karyawan.account.timeoff.detail-img-timeoff', compact('img','imgs'));
    }

    public function timeoffCancel($id)
    {
        DB::beginTransaction();
        try {


            $timeoff = new StatusRequestTimeOff();
            $id = $id;
            $timeoff->time_off_balances_id = $id;
            $timeoff->description = "Has been canceled by " . Auth::user()->employee->full_name . "";
            $timeoff->approved_by = Auth::id();
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
            $timeoff->description = "Has been canceled by " . Auth::user()->employee->full_name . "";
            $timeoff->approved_by = Auth::id();
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

        return view('admin.karyawan.account.timeoff.detail-timeoff', compact('status'));
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
            ->where('b.employee_id', Auth::user()->employee->id)
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
                ->where('delegate_from', Auth::user()->employee->id)
                ->groupBy('delegations.id')
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        } else {
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(employees.full_name) LIKE '%" . $search . "%')")
                ->offset($start)
                ->where('delegate_from', Auth::user()->employee->id)
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

        return view('admin.karyawan.account.timeoff.detail-delegation', compact('status'));
    }

    /* End  Timeoff  */

    /* Begin OverTime  */
    public function overtime($id)
    {
        $karyawan = Employee::find($id);
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.overtime.index', compact('karyawan', 'initial'));
    }
    /* End  OverTime  */


    /* Begin  Payroll  */
    public function payrollinfo($id)
    {
        $karyawan = Employee::find($id);
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.payroll.index', compact('karyawan', 'initial'));
    }

    public function payslip($id)
    {
        $karyawan = Employee::find($id);
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.payroll.payslip', compact('karyawan', 'initial'));
    }
    public function payslipThr($id)
    {
        $karyawan = Employee::find($id);
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.payroll.payslip-thr', compact('karyawan', 'initial'));
    }

    public function payslipAjax(request $request)
    {
        $id = $request->id;
        $salary_month = $request->input('salary_month');
        $column = array('salary_month', 'payroll_cut_off', 'actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = Payslip::join('employees', 'pay_slips.employee_id', '=', 'employees.id')
            ->select('pay_slips.id', 'pay_slips.salary_month', "pay_slips.id as payroll_cut_off", 'pay_slips.id as actions')
            ->where('pay_slips.employee_id', $id)
            ->orderBy('pay_slips.salary_month', 'DESC');
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        } else {
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("( LOWER(pay_slips.salary_month) LIKE '%" . $search . "%' OR LOWER(payslip_types.name) LIKE '%" . $search . "%' OR LOWER(pay_slips.basic_salary) LIKE '%" . $search . "%' OR LOWER(pay_slips.net_payble) LIKE '%" . $search . "%')")
                ->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                $paid = '<a href="' . route('employee.payroll.payslip.detail', $row->id) . '" class="btn btn-secondary btn-sm" title="View Payslip">
                            View payslip
                        </a>';
                $obj['salary_month']        = date('F', strtotime($row->salary_month));
                $obj['payroll_cut_off']     = "26 " . date("M", strtotime("-1 month", strtotime($row->salary_month))) . " - " . "25 " . date("M", strtotime($row->salary_month)) . " " . date("Y", strtotime($row->salary_month));
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
    public function payslipdetail($id)
    {

        $payslip = Payslip::find($id);
        $karyawan = Employee::where("id", $payslip->employee_id)->first();
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.payroll.detail', compact('payslip', 'initial', 'karyawan'));
    }

    public function payslipThrdetail($id)
    {
        $karyawan = Employee::find($id);
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.payroll.payslip-thr-detail', compact('initial', 'karyawan'));
    }

    public function downloadpayslippdf($id)
    {
        $payslip = DB::table('pay_slips')->where('id', $id)->latest()->first();
        $employee = Employee::find($payslip->employee_id);
        $desgination = Designation::find($employee->designation_id);
        $signature = User::find($payslip->created_by);
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => storage_path() . '/app/public/pdf',
            'format' => 'A4-P',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 15,
            'margin_header' => 10,
        ]);
        $mpdf->SetTitle($employee->name . ' | ' . date('F Y', strtotime($payslip->salary_month)));
        $mpdf->WriteHTML(view('karyawan.account.payroll.print-payslip', compact('payslip', 'employee', 'desgination', 'signature')));
        $mpdf->Output();
    }
    public function downloadpayslipThrpdf($id)
    {
        $payslip = DB::table('pay_slips')->where('id', $id)->latest()->first();
        $employee = Employee::find($id);
        // $desgination = Designation::find($employee->designation_id);
        // $signature = User::find($payslip->created_by);
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => storage_path() . '/app/public/pdf',
            'format' => 'A4-P',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 15,
            'margin_header' => 10,
        ]);
        $mpdf->SetTitle($employee->name . ' | ');
        $mpdf->WriteHTML(view('admin.karyawan.account.payroll.print-payslip-thr', compact('payslip', 'employee')));
        $mpdf->Output();
    }
    /* End  Payroll  */

    /* Begin  Payroll  */
    public function reimburstment($id)
    {
        $karyawan = Employee::find($id);
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.reimburstment.index', compact('karyawan', 'initial'));
    }


    /* Begin   Files  */
    public function files($id)
    {
        $karyawan = Employee::find($id);
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.files.index', compact('initial', 'karyawan'));
    }

    public function documentsAjax(request $request)
    {
        $id = $request->id;
        $column = array("name", "documents", "actions");
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = DB::table('documents')->select('id', 'name', 'documents', 'id as actions')
            ->where('employee_id', $id);
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        } else {
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(name) LIKE '%" . $search . "%')")
                ->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $edit = '<a href="javascript:;" data-attr="' . route('employee.files.edit', ['id' => $row->id]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-files" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus = '<a  href="javascript:;" data-attr="' . route('employee.files.show', ['id' => $row->id]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-files" title="Delete">
                            <i class="la flaticon-delete"></i>
                        </a>';
                if ($row->documents != null) {
                    $document = '<a href="' . asset("storage/documents/" . $row->documents) . '" target="_blank" class="btn btn-default  btn-icon-sm btn-sm">
                                    <i class="la la-download"></i>
                                    download
                                </a>';
                } else {
                    $document = "-";
                }
                $obj['name']            = $row->name;
                $obj['documents']       = $document;
                $obj['actions']         = $edit . '' . $hapus;
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

    public function createfile($id)
    {
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.files.create', compact('karyawan'));
    }


    public function storefile(request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'documents' => 'required|mimes:jpeg,png,pdf|max:700kb',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(['danger' => $validator->errors()->first()]);
        } else {
            if ($request->hasFile('documents')) {
                $filenameWithExt = $request->file('documents')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('documents')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $request->file('documents')->storeAs('public/documents', $fileNameToStore);
            } else {
                $fileNameToStore = "No";
            }
            $documents              = new Documents;
            $documents->employee_id = $id;
            $documents->name        = $request->name;
            $documents->documents   = $fileNameToStore;
            $documents->save();
            return redirect()->back()->with(['success' => 'Your Documents Successfull Created !']);
        }
    }

    public function editfile($id)
    {
        $documents   = Documents::find($id);
        return view('admin.karyawan.account.files.edit', compact("documents"));
    }

    public function updatefile(request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'documents' => 'required|mimes:jpeg,png|size:700',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['danger' => $validator->errors()->first()]);
        } else {

            $documents   = Documents::find($id);
            $path = '/public/documents/' . $documents->documents;
            Storage::delete($path);
            if (!Storage::exists($path)) {
                if ($request->hasFile('documents')) {
                    $filenameWithExt = $request->file('documents')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('documents')->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    $path = $request->file('documents')->storeAs('public/documents', $fileNameToStore);
                } else {
                    $fileNameToStore = $documents->documents;
                }
                $documents                  = Documents::find($id);
                $documents->name            = $request->name;
                $documents->documents   = $fileNameToStore;
                $documents->save();
                return redirect()->back()->with(['success' => 'Your Documents Successfull Created !']);
            }
        }
    }

    public function showfile($id)
    {
        $documents   = Documents::find($id);
        return view('admin.karyawan.account.files.show', compact("documents"));
    }
    public function deletefile($id)
    {
        $documents   = Documents::find($id);
        $path = '/public/documents/' . $documents->documents;
        Storage::delete($path);
        if (!Storage::exists($path)) {
            $documents->delete();
        }
        return redirect()->back()->with(['success' => 'Your Documents Successfull Deleted !']);
    }
    /* End   Files  */


    /* Begin Contract */

    public function contract($id)
    {
        $karyawan = Employee::find($id);
        $initial  = KaryawanController::getinitialname($karyawan->full_name);
        return view('admin.karyawan.account.contract.index', compact('initial', 'karyawan'));
    }

    public function contractAjax(request $request)
    {
        $id = $request->id;
        $column = array("start_date", "end_date", "contract", "actions");
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp  = DB::table('contract_employee')->select('id', 'start_date', 'end_date', 'contract', 'id as actions')
            ->where('employee_id', $id);
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        } else {
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(start_date) LIKE '%" . $search . "%')")
                ->offset($start)
                ->orderBy($order, $dir)
                ->limit($limit)
                ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $key => $row) {
                $edit = '<a href="javascript:;" data-attr="' . route('employee.contract.edit', ['id' => $row->id]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-edit-contract" title="Edit">
                            <i class="la flaticon-edit"></i>
                        </a>';
                $hapus = '<a  href="javascript:;" data-attr="' . route('employee.contract.show', ['id' => $row->id]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-show-contract" title="Delete">
                            <i class="la flaticon-delete"></i>
                        </a>';
                if ($row->contract != null) {
                    $contract = '<a href="' . asset("storage/contract/" . $row->contract) . '" target="_blank" class="btn btn-default  btn-icon-sm btn-sm">
                                    <i class="la la-download"></i>
                                    download
                                </a>';
                } else {
                    $contract = "-";
                }
                $obj['start_date']     = date("d M Y", strtotime($row->start_date));
                $obj['end_date']       = date("d M Y", strtotime($row->end_date));
                $obj['contract']       = $contract;
                $obj['actions']        = $edit . '' . $hapus;
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

    public function createContract($id)
    {
        $karyawan = Employee::find($id);
        return view('admin.karyawan.account.contract.create', compact('karyawan'));
    }

    public function storeContract(request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required',
            'contract' => 'required|mimes:jpeg,png,pdf|max:700kb',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(['danger' => $validator->errors()->first()]);
        } else {
            if ($request->hasFile('contract')) {
                $filenameWithExt = $request->file('contract')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('contract')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $request->file('contract')->storeAs('public/contract', $fileNameToStore);
            } else {
                $fileNameToStore = "No";
            }
            $contract              = new ContractEmployee;
            $contract->employee_id = $id;

            $contract->start_date  = date("Y-m-d", strtotime($request->start_date));
            $contract->end_date    = date("Y-m-d", strtotime($request->end_date));
            $contract->contract   = $fileNameToStore;
            $contract->save();
            return redirect()->back()->with(['success' => 'Your Documents Successfull Created !']);
        }
    }

    public function editContract($id)
    {
        $contract    = ContractEmployee::find($id);
        return view('admin.karyawan.account.contract.edit', compact("contract"));
    }

    public function updateContract(request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required',
            // 'documents' => 'required|mimes:jpeg,png|size:700',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['danger' => $validator->errors()->first()]);
        } else {

            $contract   = ContractEmployee::find($id);
            $path = '/public/contract/' . $contract->contract;
            Storage::delete($path);
            if (!Storage::exists($path)) {
                if ($request->hasFile('contract')) {
                    $filenameWithExt = $request->file('contract')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('contract')->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    $path = $request->file('contract')->storeAs('public/contract', $fileNameToStore);
                } else {
                    $fileNameToStore = $contract->contract;
                }
                $contract              = ContractEmployee::find($id);
                $contract->start_date  = date("Y-m-d", strtotime($request->start_date));
                $contract->end_date    = date("Y-m-d", strtotime($request->end_date));
                $contract->contract   = $fileNameToStore;
                $contract->save();
                return redirect()->back()->with(['success' => 'Your Documents Successfull Created !']);
            }
        }
    }

    public function showContract($id)
    {
        $contract   = ContractEmployee::find($id);
        return view('admin.karyawan.account.contract.show', compact("contract"));
    }

    public function deleteContract($id)
    {
        $contract   = ContractEmployee::find($id);
        $path = '/public/contract/' . $contract->contract;
        Storage::delete($path);
        if (!Storage::exists($path)) {
            $contract->delete();
        }
        return redirect()->back()->with(['success' => 'Your Documents Successfull Deleted !']);
    }

    /* End  Contract */

    public function export()
    {
        return Excel::download(new ExportKaryawan, 'employee.xlsx');
    }

    public function import(request $request)
    {

        $validator = Validator::make($request->all(), [
            'import' => 'required|mimes:csv,xls,xlsx'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['error' => 'file  not yet import!']);
        } else {
            $file = $request->file('import');
            $data = Excel::toArray(new KaryawanImport, $file);
            $nama_file = rand() . $file->getClientOriginalName();
            $file->move(public_path('/import'), $nama_file);
            $import = Excel::import(new KaryawanImport, public_path('/import/' . $nama_file));
            return redirect()->back()->with(['success' => 'Data Karyawan Suskses di Import !']);
        }
    }

    public function destroy($id)
    {
        $karyawan = Employee::find($id);
        $karyawan->delete();
        return redirect()->route('employee')->with(['success' => 'Data Karyawan Berhasil Dihapus !']);
    }
}
