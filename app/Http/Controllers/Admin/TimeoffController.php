<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use App\Exports\ExportTimeOffEmployee;
use App\Http\Controllers\Controller;
use App\SettingTimeOff;
use App\Timeoff;
use App\TimeOffEmployee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Mpdf\Tag\Input;
use Validator;
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
                    // dd($employee);
                    
        return view('admin.timeoff.assign.index', compact('timeoff', 'employee'));
    
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
            return Redirect::back()->withErrors($validator);
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

            //   dd($boot);
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
                $obj['effective_date']  = date("Y-m-d",strtotime($row->effective_date));
                if ($row->expired_date == "2000-01-01") {
                    $obj['expired_date']    = "-";
                } else {
                    $obj['expired_date']    = date("Y-m-d",strtotime($row->expired_date));
                }
                $obj['log']             = $log_history;
                $obj['action']         = $hapus;
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
            $timeoff->effective_date = $request->effective_date;
            if (!empty($request->expired_date)) {
                $timeoff->expired_date = date("Y-m-d",strtotime($request->expired_date));
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

            $timeoffemployee->save();                   
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
                    $obj['type']        = "Assign/Update";
                } else if ($row->type == "expired")
                {
                    $obj['type']        = "Expired";
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
           $employees = Employee::join('job_position', 'employees.job_position_id','=','job_position.id')
           ->join('branches', 'employees.branch_id', '=', 'branches.id')
           ->select('employees.id', 'employees.employee_id', 'join_date', 'employees.full_name', 'job_position.name as jp_name', 'branches.name as b_name')->get();
        }else{
           $employees = Employee::join('job_position', 'employees.job_position_id','=','job_position.id')
           ->join('branches', 'employees.branch_id', '=', 'branches.id')
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

        if($validator->fails()){
            return Redirect::back()->withErrors($validator);
        }else{           
        foreach ($request->employee_id as $subject)
        {
            $timeoffemployee = TimeOffEmployee::where('transaction_id', $transaction_id)->first();
            // $timeoffemployee->timeoff_id = $request->timeoff_id;
            // $timeoffemployee->type = $request->type;
            // $timeoffemployee->description = $request->description;
            // $timeoffemployee->employee_id = $subject;        
            // $timeoffemployee->input_balance = $request->input_balance;
            // $timeoffemployee->transaction_id = $transaction_id;
            // $timeoffemployee->start_date = date("Y-m-d",strtotime($request->start_date));
            // $timeoffemployee->end_date = date("Y-m-d",strtotime($request->end_date));

            $timeoffemployee::updateOrCreate([
                'timeoff_id' => $request->get('timeoff_id'),
                'type' => $request->get('type'),
                'description' => $request->get('description'),
                'employee_id' => $subject,
                'input_balance' => $request->get('input_balance'),
                'transaction_id' => $transaction_id,
                'start_date' => date("Y-m-d",strtotime($request->get('start_date'))),
                'end_date' => date("Y-m-d",strtotime($request->get('end_date')))
               
            ]);                   
        }

        

        return redirect('/timeoff/assign')->with(['success'=>'Data Time Off Sukses diupdate !']);
        }   
    }

    public function deleteAssign($transaction_id)
    {
        $timeoffemployee = DB::table('time_off_employees')->where('transaction_id', $transaction_id)->delete();

		return redirect('/timeoff/assign')->with(['success'=>'Data Time Off Berhasil di Delete !']);
    }


    public function logHistory()
    {
        return view('admin.timeoff.log');
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
            // dd($tess);
        }

    }
    
    public function simulation($id){
            $joindate = Employee::where('id', $id)->first('join_date');
            // dd($joindate->join_date);
            return response()->json($joindate);
    }

    // public function calculate_simulation(Request $request)
    // {
    //     $toDate = Carbon::createFromFormat('Y-m-d', $request->current_date);
    //     $fromDate = Carbon::createFromFormat('Y-m-d', $request->jd)->addMonth();

    //     $years = $toDate->diffInMonths($fromDate);
    //     dd($request->all());
    //     return response()->json($years);
    // }

    public function exportTimeoffassign(Request $request)
    {
        return Excel::download(new ExportTimeOffEmployee, 'export-timeoff-employee.xlsx');
    }
}
