<?php

namespace App\Http\Controllers\Admin;

use App\Branch;
use App\Department;
use App\Employee;
use App\Exports\ExportTimeOffEmployee;
use App\Exports\ExportTimeOffEmployeeMultipleSheets;
use App\Http\Controllers\Controller;
use App\Imports\ImportTimeOffEmployee;
use App\Joblevel;
use App\JobPosition;
use App\LogTimeOffBalance;
use App\SettingTimeOff;
use App\Tes;
use App\Timeoff;
use App\TimeoffBalance;
use App\TimeOffEmployee;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Mpdf\Tag\Input;
// use Validator;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;
use KitLoong\MigrationsGenerator\Setting;
use Maatwebsite\Excel\Facades\Excel;

class TimeoffController extends Controller
{
    public function index()
    {
        $timeoff = Timeoff::whereIn('code', ['CT','CTMKT','OTL'])->get();
        // dd($timeoff);
        return view('admin.timeoff.index', compact('timeoff'));
    }
    public function indexAssign()
    {
        $timeoff = Timeoff::select('id', 'name', 'code')->get();
        $employee = Employee::join('job_position', 'employees.job_position_id','=','job_position.id')
                    ->join('branches', 'employees.branch_id', '=', 'branches.id')
                    ->select('employees.id', 'employees.employee_id', 'employees.full_name', 'job_position.name as jp_name', 'branches.name as b_name')
                    ->get();
        // $dt = new DateTime();
        $timeoffemployee = TimeOffEmployee::where('end_date', '<', date("Y-m-d",strtotime(Carbon::now())))->get();
        // dd($timeoffemployee);
        foreach ($timeoffemployee as $key) {
                $key->type = 'expired';
                $key->save();
        }


        return view('admin.timeoff.assign.index', compact('timeoff', 'employee', 'timeoffemployee'));

    }
    public function create()
    {
        return view('admin.timeoff.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'code' =>'required|unique:timeoffs',
            'effective_date' =>'required',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }else{

        $timeoff = new Timeoff();

        $timeoff->name = $request->name;
        $timeoff->code = $request->code;
        $timeoff->description = $request->description;
        $timeoff->effective_date = date("Y-m-d",strtotime($request->effective_date));
        if (!empty($request->expired_date)) {
            $timeoff->expired_date = date("Y-m-d",strtotime($request->expired_date));
        } else {
            $timeoff->expired_date = "2000-01-01";
        }

        $timeoff->save();

        $timeoffsetting = new SettingTimeOff();
        $timeoffsetting->timeoff_id = $timeoff->id;


        $timeoffsetting->save();

        return redirect('/timeoff')->with(['success'=>'Data Time Off Sukses dibuat !']);
        }
    }

    public function timeoffajax(Request $request)
    {
        $column = array('name','code','effective_date','expired_date','log','action');

        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp = Timeoff::select('*');
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(timeoffs.name) LIKE '%".$search."%' OR LOWER(timeoffs.code) LIKE '%".$search."%' )")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();

        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                $hapus ='<button class="btn btn-sm btn-clean btn-icon btn-icon-md" data-id="' . $row->id . '" data-route=' . route('timeoff.update', $row->id) . ' data-name=\'' . $row->name . '\' data-code="' . $row->code . '" data-description="' . $row->description . '" data-effective_date="' . $row->effective_date . '" data-expired_date="' . $row->expired_date . '"  id="btn-edit" title="Edit">
                    <i class="la flaticon-edit"></i>
                </button>';
                $log_history = '<a href="/timeoff/log" class="kt-link kt-font-bold">Log History</a>';
                $obj['name']            = $row->name;
                $obj['code']            = $row->code;
                $obj['effective_date']  = date("d/m/Y",strtotime($row->effective_date));
                if ($row->expired_date == "2000-01-01") {
                    $obj['expired_date']    = "-";
                } else {
                    $obj['expired_date']    = date("d/m/Y",strtotime($row->expired_date));
                }
                $obj['log']             = $log_history;
                $obj['action']          = $hapus;
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

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $timeoff = Timeoff::findOrFail($id);
            $timeoff->name = $request->name;
            $timeoff->code = $request->code;
            $timeoff->description = $request->deskripsiEdit;
            $timeoff->effective_date = Carbon::createFromFormat('d/m/Y', $request->effective_date)->format("Y-m-d");
            if (!empty($request->expired_date)) {
                $timeoff->expired_date = Carbon::createFromFormat('d/m/Y', $request->effective_date)->format("Y-m-d");
            } else {
                $timeoff->expired_date = "2000-01-01";
            }


            // dd($request->all());
            $timeoff->save();
            // ->with(['success'=>'Data Time Off Sukses dibuat !'])
            DB::commit();
            $message = ['status'=> true, 'message'=>'Data Time Off Sukses diupdate !'];
            return response()->json($message, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = ['status'=> false, 'message'=>'Data Time Off Sukses diupdate !'];
            return response()->json($message, 400);
        }
    }

    public function createAssign()
    {
        $timeoff = Timeoff::select('id', 'name', 'code')->get();
        $employee = Employee::join('job_position', 'employees.job_position_id','=','job_position.id')
                    ->join('branches', 'employees.branch_id', '=', 'branches.id')
                    ->select('employees.id', 'employees.employee_id', 'employees.full_name', 'job_position.name as jp_name', 'branches.name as b_name')
                    ->get();
                    // dd($employee);
        return view('admin.timeoff.assign.create', compact('timeoff', 'employee'));
    }

    public function storeAssign(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'timeoff_id' => 'required',
            'type' =>'required',
            'description' =>'required',
            'employee_id' =>'required',
            'input_balance' =>'required',
            'start_date' =>'required',
            'end_date' =>'required',
        ]);
        if($validator->fails()){
            return Redirect::back()->withErrors($validator);
        }else{

        $latestOrder = TimeOffEmployee::orderBy('created_at','DESC')->first();
        if ($latestOrder) {
            $order_nr = 'TID-'.str_pad($latestOrder['id'] + 1, 8, "0", STR_PAD_LEFT);

        } else {
            $order_nr = 'TID-00000001';
        }


        foreach ($request->employee_id as $subject)
        {
            $timeoffemployee = new TimeOffEmployee();
            $timeoffemployee->timeoff_id = $request->timeoff_id;
            $timeoffemployee->type = $request->type;
            $timeoffemployee->description = $request->description;
            $timeoffemployee->employee_id = $subject;
            $timeoffemployee->input_balance = $request->input_balance;
            $timeoffemployee->transaction_id = $order_nr;
            $timeoffemployee->start_date = date("Y-m-d",strtotime($request->start_date));
            $timeoffemployee->end_date = date("Y-m-d",strtotime($request->end_date));
            $timeoffemployee->created_by = Auth::user()->employee->id;

            $timeoffemployee->save();
            
            $logs = LogTimeOffBalance::where('employee_id', $subject)->where('timeoff_id', $request->timeoff_id)->orderBy('id', 'desc')->first();
            // dd($logs);
            // insert log time off
            $log_timeoff_balance = new LogTimeOffBalance();
            $log_timeoff_balance->created_by = Auth::user()->employee->id;
            $log_timeoff_balance->employee_id = $subject;
            $log_timeoff_balance->transaction_id = $order_nr;
            $log_timeoff_balance->timeoff_id = $request->timeoff_id;
            if ($request->type == 'assign_update') {
                $log_timeoff_balance->type = "beginning_balance";
            } elseif ($request->type == 'update') {
                $log_timeoff_balance->type = "adjusment";
            } elseif ($request->type == 'expired') {
                $log_timeoff_balance->type = "expired";
            }
            $log_timeoff_balance->value = $request->input_balance;
            if ($logs) {
                $log_timeoff_balance->ending_balance = $logs->ending_balance + $request->input_balance;
            } else {
                $log_timeoff_balance->ending_balance = $request->input_balance;
            }
            $log_timeoff_balance->start_date = date("Y-m-d",strtotime($request->start_date));
            $log_timeoff_balance->end_date = date("Y-m-d",strtotime($request->end_date));
            $log_timeoff_balance->status = 0;
            if ($request->type == 'expired') {
                $log_timeoff_balance->action = "Expired";
            } else {
                $log_timeoff_balance->action = "Transaction";
            }

            $log_timeoff_balance->save();
        }

        return redirect('/timeoff/assign')->with(['success'=>'Data Time Off Sukses dibuat !']);
        }
    }

    public function timeoffassignajax(Request $request)
    {
        $column = array('no','timeoff_type','type','transaction_id','description','action');

        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');

        $temp = TimeOffEmployee::join('timeoffs', 'time_off_employees.timeoff_id', '=', 'timeoffs.id')
                               ->select('time_off_employees.id', 'time_off_employees.type', 'time_off_employees.transaction_id','time_off_employees.description', 'timeoffs.name as timeoff_type');
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->groupBy('time_off_employees.transaction_id')
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(time_off_employees.transaction_id) LIKE '%".$search."%' OR LOWER(timeoffsName) LIKE '%".$search."%' )")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->groupBy('time_off_employees.transaction_id')
              ->get();

            //   dd($boot);
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {


                $action =
                '<a href=' . route('timeoff.assign.edit', $row->transaction_id) . ' class="btn btn-sm btn-clean btn-icon btn-icon-md" id="btn-edit" title="Edit"
                data-id="' . $row->id . '" data-route=' . route('timeoff.assign.edit', $row->transaction_id) . ' data-type=\'' . $row->type . '\' data-timeoff_type="' . $row->timeoff_type . '" data-transaction_id="' . $row->transaction_id . '" data-description="' . $row->description . '"
                >
                <i class="la flaticon-edit text-info"></i></a>
               <button id="btn-delete" data-id="' . $row->id . '" data-route=' . route('timeoff.assign.delete', $row->transaction_id) . ' data-type=\'' . $row->type . '\' data-timeoff_type="' . $row->timeoff_type . '" data-transaction_id="' . $row->transaction_id . '" data-description="' . $row->description . '" data-target="#kt_modal_1" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Hapus">
                            <i class="la flaticon-delete text-danger"></i>
               </button>';

                if ($row->type == "assign_update")
                {
                    $obj['type']        = "Assign";
                } else if ($row->type == "expired")
                {
                    $obj['type']        = "Expired";
                } else if ($row->type == "update")
                {
                    $obj['type']        = "Update";
                } else {
                    $obj['type']        = "";
                }
                $obj['timeoff_type']    = $row->timeoff_type;
                $obj['transaction_id']  = $row->transaction_id;
                $obj['description']     = $row->description;
                $obj['action']          = $action;
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


    public function getEmployees(Request $request){
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


    public function editAssign($transaction_id)
    {
        $timeoffemployee = TimeOffEmployee::where('transaction_id', $transaction_id)->first();
        $timeoffemployeeGet = TimeOffEmployee::where('transaction_id', $transaction_id)->pluck('employee_id')->toArray();
        // dd($timeoffemployeeGet);
        // $tess = time
        // dd($timeoffemployeeGet[0]['employee_id']);
        $timeoff = Timeoff::select('id', 'name', 'code')->get();
        $employee = Employee::join('job_position', 'employees.job_position_id','=','job_position.id')
                    ->join('branches', 'employees.branch_id', '=', 'branches.id')
                    ->select('employees.id', 'employees.employee_id', 'employees.full_name', 'job_position.name as jp_name', 'branches.name as b_name')
                    ->get();

        return view('admin.timeoff.assign.edit', compact('timeoffemployee','timeoff','employee','timeoffemployeeGet'));
    }

    public function updateAssign(Request $request, $transaction_id)
    {
        $validator = Validator::make($request->all(),[
            'timeoff_id' => 'required',
            'type' =>'required',
            'description' =>'required',
            'employee_id' =>'required',
            'input_balance' =>'required',
            'start_date' =>'required',
            'end_date' =>'required',
        ]);
        $inputb = TimeOffEmployee::where('transaction_id', $transaction_id)->first();
        if($validator->fails()){
            return Redirect::back()->withErrors($validator);
        }else{
        foreach ($request->employee_id as $subject)
        {
            $timeoffemployee = TimeOffEmployee::where('transaction_id', $transaction_id)->first();
            $timeoffemployee->created_by = Auth::user()->employee->id;
            $timeoffemployee->timeoff_id = $request->get('timeoff_id');
            $timeoffemployee->description = $request->get('description');
            $timeoffemployee->employee_id = $subject;
            $timeoffemployee->input_balance = $request->get('input_balance');
            $timeoffemployee->transaction_id = $transaction_id;
            $timeoffemployee->start_date = date("Y-m-d",strtotime($request->get('start_date')));
            $timeoffemployee->end_date = date("Y-m-d",strtotime($request->get('end_date')));
            $timeoffemployee->save();

            // kemaren aman aman aja, sekarang error. wkwk
            // $timeoffemployee::updateOrCreate([
            //     'timeoff_id' => $request->get('timeoff_id'),
            //     'type' => $request->get('type'),
            //     'description' => $request->get('description'),
            //     'employee_id' => $subject,
            //     'input_balance' => $request->get('input_balance'),
            //     'transaction_id' => $transaction_id,
            //     'start_date' => date("Y-m-d",strtotime($request->get('start_date'))),
            //     'end_date' => date("Y-m-d",strtotime($request->get('end_date')))

            // ]);

            $log_timeoff_balance = LogTimeOffBalance::where('transaction_id', $transaction_id)->first();
            $logs = LogTimeOffBalance::where('employee_id', $subject)->where('timeoff_id', $timeoffemployee->timeoff_id)->orderBy('id', 'desc')->first();
            
            // dd($inputb);
            $log_timeoff_balance->created_by = Auth::user()->employee->id;
            $log_timeoff_balance->employee_id = $subject;
            $log_timeoff_balance->timeoff_id = $request->timeoff_id;
            if ($request->type == 'assign_update') {
                $log_timeoff_balance->type = "beginning_balance";
            } elseif ($request->type == 'update') {
                $log_timeoff_balance->type = "adjusment";
            } elseif ($request->type == 'expired') {
                $log_timeoff_balance->type = "expired";
            }
            $log_timeoff_balance->value = $request->input_balance;
            if ($logs) {
                $log_timeoff_balance->ending_balance = $logs->ending_balance + ($request->input_balance-$inputb->input_balance);
            } else {
                $log_timeoff_balance->ending_balance = $request->input_balance;
            }
            $log_timeoff_balance->start_date = date("Y-m-d",strtotime($request->start_date));
            $log_timeoff_balance->end_date = date("Y-m-d",strtotime($request->end_date));
            $log_timeoff_balance->status = 0;
            if ($request->type == 'expired') {
                $log_timeoff_balance->action = "Expired";
            } else {
                $log_timeoff_balance->action = "Transaction";
            }

            $log_timeoff_balance->save();

        }
        return redirect('/timeoff/assign')->with(['success'=>'Data Time Off Sukses diupdate !']);
        }
    }

    public function deleteAssign($transaction_id)
    {
        $timeoffemployee = DB::table('time_off_employees')->where('transaction_id', $transaction_id)->delete();
        $log_timeoff_balance = DB::table('log_time_off_balances')->where('transaction_id', $transaction_id)->delete();

		return redirect('/timeoff/assign')->with(['success'=>'Data Time Off Berhasil di Delete !']);
    }

    public function logHistory()
    {
        
        $timeoff = Timeoff::all();
        $branch = Branch::all();
        $department = Department::all();
        $position = JobPosition::all();
        $joblevel = Joblevel::all();
        return view('admin.timeoff.log', compact('timeoff','branch','department','position','joblevel'));
    }
    public function setting()
    {
        $setting = SettingTimeOff::all();
        $timeoff= Timeoff::all();
        return view('admin.timeoff.setting', compact('setting', 'timeoff'));
    }

    public function settingUpdate(Request $request)
    {
        $data = [];
        $error = 1;
        for($x=0; $x < count($request->get('timeoff_id')); $x++) {
            $noId = 0;
            // dd($request->all());
            if(!empty($request->get('id')[$x]) && !$request->get('id')[$x] == 0) {
                $noId = $request->get('id')[$x];
            }
            $data[] = [
                'id' => $noId,
                'timeoff_id' => $request->get('timeoff_id')[$x],
                'duration' => $request->get('duration')[$x],
                'include_day_off' => $request->get('include_day_off')[$x],
                'allow_half_day' => $request->get('allow_half_day')[$x],
                'set_schedule_half_day' => $request->get('set_schedule_half_day')[$x],
                'set_default' => $request->get('set_default')[$x],
                'emerge_at_join' => $request->get('emerge_at_join')[$x],
                'show' => $request->get('show')[$x],
                'max_request' => $request->get('max_request')[$x],
                'allow_minus' => $request->get('allow_minus')[$x],
                'minus_amount' => $request->get('minus_amount')[$x],
                'carry_forward' => $request->get('carry_forward')[$x],
                'carry_amount' => $request->get('carry_amount')[$x],
                'carry_expired' => $request->get('carry_expired')[$x],
                'time_off_compensation' => $request->get('time_off_compensation')[$x],
                'attachment_mandatory' => $request->get('attachment_mandatory')[$x]

            ];
        }
        // dd($data);

        if(count($data) > 0) {
            $error = '';
        }

        foreach ($data as $tes) {
            // print_r($tes);
            // SettingTimeOff::where('id', $noId)->update(['id'=> $tes['id'], 'timeoff_id' => $tes['timeoff_id'],'duration'=>$tes['duration']]);
            $tess = DB::table('setting_time_offs')->where('id', $tes['id'])->update(array(
                'timeoff_id' => $tes['timeoff_id'],
                'duration' => $tes['duration'],
                'include_day_off' => $tes['include_day_off'],
                'allow_half_day' => $tes['allow_half_day'],
                'set_schedule_half_day' => $tes['set_schedule_half_day'],
                'set_default' => $tes['set_default'],
                'emerge_at_join' => $tes['emerge_at_join'],
                'show' => $tes['show'],
                'max_request' => $tes['max_request'],
                'allow_minus' => $tes['allow_minus'],
                'minus_amount' => $tes['minus_amount'],
                'carry_amount' => $tes['carry_amount'],
                'carry_forward' => $tes['carry_forward'],
                'carry_expired' => $tes['carry_expired'],
                'time_off_compensation' => $tes['time_off_compensation'],
                'attachment_mandatory' => $tes['attachment_mandatory']
            ));

            return redirect()->back()->with(['success' => 'Data berhasil di Update']);
            // dd($tess);
        }

    }

    public function simulation($id){
            $joindate = Employee::where('id', $id)->first('join_date');
            // dd($joindate->join_date);
            return response()->json($joindate);
    }

    public function exportTimeoffassign(Request $request)
    {
        return Excel::download(new ExportTimeOffEmployeeMultipleSheets, 'export-timeoff-employee.xlsx');
    }

    public function importTimeoffassign(Request $request, Collection $rows)
    {
        $validator = FacadesValidator::make($request->all(),[
            'import' => 'required|mimes:csv,xls,xlsx'
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['error'=>'file  not yet import!']);
        }else{

            $file = $request->file('import');
            $import = new ImportTimeOffEmployee();
            // $import->setStartRow(2);
            $rows = Excel::toArray($import, $file);

            $latestOrder = TimeOffEmployee::orderBy('created_at','DESC')->first();


            if ($latestOrder) {
                $order_nr = 'TID-'.str_pad($latestOrder['id'] + 1, 8, "0", STR_PAD_LEFT);

            } else {
                $order_nr = 'TID-00000001';

            }

            foreach ($rows as $row)
            {
                foreach ($row as $value) {
                    $employeeId = TimeOffEmployee::where('employee_id', $value[4])->pluck('employee_id');

                    if ($employeeId->count() > 0) {
                        $employeeUpdate = TimeOffEmployee::where('employee_id', $employeeId)->update([
                            'timeoff_id' => intval($value[1]),
                            'type' => $value[2],
                            'description' => $value[3],
                            'input_balance' => intval($value[5]),
                            'start_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value[6])->format('Y-m-d'),
                            'end_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value[7])->format('Y-m-d'),
                        ]);

                    } else {
                        $employeeUpdate = new TimeOffEmployee();
                        $employeeUpdate->transaction_id = $order_nr;
                        $employeeUpdate->timeoff_id = intval($value[1]);
                        $employeeUpdate->type = $value[2];
                        $employeeUpdate->description = $value[3];
                        $employeeUpdate->employee_id = $value[4];
                        $employeeUpdate->input_balance = $value[5];
                        $employeeUpdate->start_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value[6])->format('Y-m-d');
                        $employeeUpdate->end_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value[7])->format('Y-m-d');

                        $employeeUpdate->save();
                    }

                }

            }
        }
        return back()->with(['success' => 'Data berhasil di Import']);
    }

    public function timeoffbalanceajax(Request $request)
    {
        $column = array('full_name','jp_name','timeoff_name','branch_name','beginning_balance','timeoff_taken','adjusment','expired','carry_forward','ending_balance');
        
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        
        $temp = LogTimeOffBalance::join('employees', 'employees.id', '=', 'log_time_off_balances.employee_id')
                ->join('timeoffs', 'timeoffs.id', '=', 'log_time_off_balances.timeoff_id')
                ->join('job_position', 'job_position.id', '=', 'employees.job_position_id')
                ->join('branches', 'employees.branch_id','=','branches.id')
                ->groupBy('timeoffs.id')
                ->groupBy('employees.id')
                ->select('log_time_off_balances.*', 'timeoffs.name as timeoff_name', 'employees.full_name', 'employees.employee_id', 'employees.id as empId', 
                'employees.is_active','job_position.name as jp_name','branches.name as branch_name',
                )
                ;

        $total = $temp->count();
        $totalFiltered = $total;
        
        //filter request date range dan select timeoff
        if ($request->dateend && $request->datestart && $request->select_timeoff) {
            $temp = $temp->whereDate('log_time_off_balances.created_at', '>=', $request->datestart)
            ->whereDate('log_time_off_balances.created_at', '<=', $request->dateend)
            ->where('log_time_off_balances.timeoff_id', $request->select_timeoff);
        }
        
        //filter by status
        if ($request->input('statusText')) {
            $temp->whereIn('employees.is_active', explode(',', intval($request->input('statusText'))));
        }

        //filter by branch
        if ($request->input('branchText')) {
            $temp->whereIn('employees.branch_id', explode(',', $request->input('branchText')));
        }

        //filter by department
        if ($request->input('departmentText')) {
            $temp->whereIn('employees.department_id', explode(',', $request->input('departmentText')));
        }

        //filter by position
        if ($request->input('positionText')) {
            $temp->whereIn('employees.job_position_id', explode(',', $request->input('positionText')));
        }

        //filter by joblevel
        if ($request->input('joblevelText')) {
            $temp->whereIn('employees.job_level_id', explode(',', $request->input('joblevelText')));
        }

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(employees.full_name) LIKE '%".$search."%' OR LOWER(job_position.name) LIKE '%".$search."%' )")
              ->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        // $total = $boot->count();
        // $totalFiltered = $total;
        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {
                // get beginning balance latest
                $beginning_bal = DB::table('time_off_employees')->where('employee_id', $row->empId)->where('timeoff_id', $row->timeoff_id)->where('type', 'assign_update')->orderBy('id', 'desc')->first();

                // get ending balance latest
                $ending_bal = LogTimeOffBalance::where('employee_id', $row->empId)->where('timeoff_id', $row->timeoff_id)->orderBy('id', 'desc')->first();
                
                // get timeoff taken
                $timeofftaken = LogTimeOffBalance::where('employee_id', $row->empId)->where('timeoff_id', $row->timeoff_id)->where('type','time_off_taken')
                // ->where('start_date', '>', $beginning_bal->start_date)
                // ->where('end_date', '<', $beginning_bal->end_date)
                ->sum('value');

                // get adjusment
                $adjusment = LogTimeOffBalance::where('employee_id', $row->empId)->where('timeoff_id', $row->timeoff_id)
                ->where('type','adjusment')
                // ->where('start_date', '>', $beginning_bal->start_date)
                // ->where('end_date', '<', $beginning_bal->end_date)
                ->sum('value');

                // get expired
                $expired = LogTimeOffBalance::where('employee_id', $row->empId)->where('timeoff_id', $row->timeoff_id)->where('type','expired')->where('end_date', '<', $beginning_bal->end_date)->sum('value');
                // dd($expired);
                // get carry forward
                $carry = LogTimeOffBalance::where('employee_id', $row->empId)
                ->where('timeoff_id', $row->timeoff_id)
                ->where('type','carry_forward')
                // ->whereDate('start_date', '>', Carbon::parse($row->start_date)->format("Y-m-d"))
                // ->whereDate('end_date', '<', Carbon::parse($row->end_date)->format("Y-m-d"))
                ->sum('value');
                
                // template column employee
                $employeeFullName = "$row->full_name <div><small>$row->employee_id</small> </div>";
                
                $obj['employee']            = $employeeFullName;
                $obj['job_position']        = $row->jp_name;
                $obj['type_timeoff']        = "<div class='text-uppercase'>$row->timeoff_name</div>";
                $obj['branch']              = $row->branch_name;

                if ($beginning_bal->input_balance != 0) {
                    $obj['beginning_balance']   = "<div class='text-center text-success font-weight-bold'>".$beginning_bal->input_balance."</div>";
                } else {
                    $obj['beginning_balance']   = "<div class='text-center'>".$beginning_bal->input_balance."</div>";
                }
                
                if ($adjusment != 0) {
                    $obj['adjusment'] = "<div class='text-center hover text-success font-weight-bold' data-toggle='modal' data-target='#kt_modal_1' data-empid='".$row->empId."' data-timeoffid='".$row->timeoff_id."' data-timeoffname='".$row->timeoff_name."' data-type='adjusment' data-type1='Adjusment'>". $adjusment ."</div>";
                } else {
                    $obj['adjusment'] = "<div class='text-center hover' data-toggle='modal' data-target='#kt_modal_1' data-empid='".$row->empId."' data-timeoffid='".$row->timeoff_id."' data-timeoffname='".$row->timeoff_name."' data-type='adjusment' data-type1='Adjusment'>". $adjusment ."</div>";
                }
                
                if ($timeofftaken != 0) {
                    $obj['timeoff_taken'] = "<div class='text-center text-danger hover font-weight-bold' data-toggle='modal' data-target='#kt_modal_1' data-empid='".$row->empId."' data-timeoffid='".$row->timeoff_id."' data-timeoffname='".$row->timeoff_name."' data-type='time_off_taken' data-type1='Time Off Taken'>".$timeofftaken."</div>";
                } else {
                    $obj['timeoff_taken'] = "<div class='text-center hover' data-toggle='modal' data-target='#kt_modal_1' data-empid='".$row->empId."' data-timeoffid='".$row->timeoff_id."' data-timeoffname='".$row->timeoff_name."' data-type='time_off_taken' data-type1='Time Off Taken'>".$timeofftaken."</div>";
                }
                
                if ($carry != 0) {
                    $obj['carry_forward'] = "<div class='text-center hover text-success font-weight-bold' data-toggle='modal' data-target='#kt_modal_1' data-empid='".$row->empId."' data-timeoffid='".$row->timeoff_id."' data-timeoffname='".$row->timeoff_name."' data-type='carry_forward' data-type1='Carry Forward'>". $carry ."</div>";
                } else {
                    $obj['carry_forward'] = "<div class='text-center hover' data-toggle='modal' data-target='#kt_modal_1' data-empid='".$row->empId."' data-timeoffid='".$row->timeoff_id."' data-timeoffname='".$row->timeoff_name."' data-type='carry_forward' data-type1='Carry Forward'>". $carry ."</div>";
                }
                
                
                
                if ($expired != 0) {
                    $obj['expired']         = "<div class='text-danger hover text-center font-weight-bold' data-toggle='modal' data-target='#kt_modal_1' data-empid='".$row->empId."' data-timeoffid='".$row->timeoff_id."' data-timeoffname='".$row->timeoff_name."' data-type='expired' data-type1='Expired'>".$expired."</a>";
                } else {
                    $obj['expired']         = "<div class='hover text-center' data-toggle='modal' data-target='#kt_modal_1' data-empid='".$row->empId."' data-timeoffid='".$row->timeoff_id."' data-timeoffname='".$row->timeoff_name."' data-type='expired' data-type1='Expired'>".$expired."</a>";
                }  
                $obj['ending_balance']      = "<div class='text-center text-success font-weight-bold'>".$ending_bal->ending_balance."</div>";
                
                
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


    public function logbalanceajax(Request $request)
    {
        $columns = array('created_at','empid','full_name','jp_name','branch_name','type_timeoff','action','balance','detail');
        
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $columns[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');


        $temp = LogTimeOffBalance::
        join('timeoffs', 'timeoffs.id','=', 'log_time_off_balances.timeoff_id')
        ->join('employees', 'employees.id','=', 'log_time_off_balances.employee_id')
        ->join('job_position', 'job_position.id', '=', 'employees.job_position_id')
        ->join('branches', 'branches.id', '=', 'employees.branch_id')
        ->select('log_time_off_balances.*', 'timeoffs.name as timeoff_name', 'employees.employee_id as empid', 'employees.full_name', 'job_position.name as jp_name', 'branches.name as branch_name');

        $total = $temp->count();
        $totalFiltered = $total;
        //filter request date range dan select timeoff
        if ($request->toDate2 && $request->fromDate2 && $request->selectTimeoff2) {
            $temp = $temp->whereDate('log_time_off_balances.created_at', '>=', $request->fromDate2)
            ->whereDate('log_time_off_balances.created_at', '<=', $request->toDate2)
            ->where('log_time_off_balances.timeoff_id', $request->selectTimeoff2);
        }
        
        //filter by employee
        // dd($request->input('select-employee'));
        if ($request->input('select_employee')) {
            $temp->whereIn('log_time_off_balances.employee_id', $request->input('select_employee'));
        }

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
             ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }else{
            $search = $request->input('search.value');
            $boot   = $temp->whereRaw("(LOWER(employees.full_name) LIKE '%".$search."%' OR LOWER(job_position.name) LIKE '%".$search."%' )")
            ->orderBy($order,$dir)  
            ->offset($start)
              ->limit($limit)
              ->get();
        }


        $data = array();
        if (!empty($boot)) {
            foreach ($boot as  $row) {

                $balance='';
                if ($row->transactions != 'assign_update') {
                    $balance = "<a class='text-danger fw-bold'>-$row->balance</a>";
                } else {
                    $balance = $row->balance;
                }

                $obj['created_at']          = date("d-M-Y",strtotime($row->created_at));
                $obj['employee_id']         = $row->empid;
                $obj['employee']            = $row->full_name;
                $obj['job_position']        = $row->jp_name;
                $obj['branch']              = $row->branch_name;
                $obj['type_timeoff']        = "<div class='text-uppercase'>$row->timeoff_name</div>";
                $obj['action']              = $row->action;
                if ($row->type == 'time_off_taken' || $row->type == 'expired') {
                    $obj['balance']         = "<div class='text-center font-weight-bold text-danger'>$row->value</div>";
                } else {
                    $obj['balance']         = "<div class='text-center font-weight-bold text-success'>$row->value</div>";
                }
                
                if ($row->action == 'Expired') {
                    $obj['detail']          = '<div data-html="true" data-toggle="popover" class="text-primary hover text-center" title="<strong>'.$row->action.'</strong>" data-content="'.$row->value.' days '.$row->timeoff_name.' of '.$row->full_name.' is expired by sistem">View Detail</div>';
                } else {
                    $obj['detail']          = '<div tabindex="0" data-html="true" data-toggle="popover" data-trigger="focus" class="text-primary hover text-center" title="<strong>'.$row->action.'</strong>" data-content="'.$row->value.' days '.$row->timeoff_name.' '.$row->full_name.' is '.$row->action.' by sistem <br><hr>expired date : '.$row->end_date.'">View Detail</div>';
                }
                
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

    public function logmodal($timeoff_id, $employee_id, $type)
    {
        $logs = LogTimeOffBalance::where('timeoff_id', $timeoff_id)->where('employee_id', $employee_id)->where('type', $type)->get();
        // dd($tes);
        return view('admin.timeoff.log-modal', compact('logs'));
    }
}
