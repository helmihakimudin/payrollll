<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Employee;
use App\TimeManagement;
use App\ScheduleAssignment;
use Illuminate\Http\Request;
use App\Branch;
use App\Department;
use App\JobPosition;
use App\Shift;
use App\Izin;
use App\AttendanceEmployee;
use App\TimeOffEmployee;
use App\TimeOff;
use App\TimeOffBalance;
use App\EmployeeRequestOvertime;
use App\StatusRequestOvertime;
use App\StatusRequestTimeOff;
use Validator;
use DateTime;
use DatePeriod;
use DateInterval;
use Auth;
use DB;

class TimeManagementController extends Controller
{
    public function index()
    {
        return view("admin.time-management.index");
    }

    public function attendAjax(request $request)
    {
        $column = array('full_name','employee_id','date','shift_name','working_hour_start','working_hour_end','clock_in','clock_out','attendance_code','time_off_code','time_off_name','overtime');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        $temp = TimeManagement::leftJoin('employees','employees.id','attendance_employee.employee_id')
                ->leftJoin('attendances','attendances.id','attendance_employee.attendance_id')
                ->select('attendance_employee.*','employees.full_name','attendances.calendar_id');
        $total = $temp->count();
        $totalFiltered = $total;

        if (empty($request->input('search.value'))) {
            $boot  = $temp->offset($start)
              ->orderBy($order,$dir)
              ->limit($limit)
              ->get();
        }

        $data = array();
        if (!empty($boot)) {
            foreach ($boot as $row) {

                $date = date('Y-m-d', strtotime($row->created_at));

                //get data shift
                $shift = ScheduleAssignment::leftJoin('shifts as s', 's.id', '=', 'schedule_assignments.shift_id')
                ->select('schedule_assignments.*', 's.name as shift_name', 's.working_hour_start', 's.working_hour_end')
                ->where('employee_id', $row->employee_id)->where(function($query) use ($date){
                    $query->where('schedule_assignments.start_date', '<=', $date);
                    $query->where('schedule_assignments.end_date', '>=', $date);
                })->first();

                //get data time off
                $time_off = TimeOffBalance::select('timeoffs.code as time_off_code', 'timeoffs.name as time_off_name')
                ->leftJoin('timeoffs', 'timeoffs.id', '=', 'time_off_balances.timeoff_id')
                ->where('employee_id', $row->employee_id)->where(function($query) use ($date){
                    $query->where('time_off_balances.start_date', '<=', $date);
                    $query->where('time_off_balances.end_date', '>=', $date);
                })->first();

                $overtime = EmployeeRequestOvertime::select('*', DB::raw('sec_to_time(time_to_sec(overtime_before)+time_to_sec(overtime_after)) total_overtime'))
                ->where('employee_id', $row->employee_id)
                ->Where(DB::raw('date(date_request)'), $date)->first();
                
                if(isset($row->clock_in)){
                    $clock_in = substr($row->clock_in, 0, 5);
                }else{
                    $clock_in = "-";
                }

                if(isset($row->clock_out)){
                    $clock_out = substr($row->clock_out, 0, 5);
                }else{
                    $clock_out = "-";
                }
                
                $edit ='<a href="#" data-toggle="modal" data-target="#kt_modal_1" onclick="vm.attendanceDetail('.$row->id.')" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="edit">
                            <i class="la la-edit"></i>
                        </a>';

                $hapus ='<a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" onclick="vm.setIdForDelete('.$row->id.')" title="Delete" data-toggle="modal" data-target="#modal-confirm-delete">
                            <i class="la flaticon-delete"></i>
                        </a>';

                $obj['full_name']        = $row->full_name;
                $obj['employee_id']      = $row->employee_id;
                $obj['date']             = date('d M Y', strtotime($row->created_at));
                $obj['clock_in']         = $clock_in;
                $obj['clock_out']        = $clock_out;
                $obj['schedule_in']      = $shift ? substr($shift->working_hour_start, 0, 5) : '-';
                $obj['schedule_out']     = $shift ? substr($shift->working_hour_end, 0, 5) : '-';
                $obj['attendance_code']  = $row->attendance_code;
                $obj['time_off_code']    = $time_off ? $time_off->time_off_code : '';
                $obj['time_off_name']    = $time_off ? $time_off->type_leave : '';
                $obj['overtime']         = $overtime ? substr($overtime->total_overtime, 0, 5) : '';
                $obj['actions']          = $edit.''.$hapus;
                $obj['shift_name']       = $shift ? $shift->shift_name:'';
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

    public function attendanceDetail(request $request)
    {
        
        $attendance = TimeManagement::join('employees','employees.id','attendance_employee.employee_id')
                ->join('attendances','attendances.id','attendance_employee.attendance_id')
                ->select('attendance_employee.*','employees.full_name','attendances.calendar_id')
                ->where('attendance_employee.id', $request->id)
                ->first();

        if($attendance){
            $date = date('Y-m-d', strtotime($attendance->created_at));

            //get data shift
            $shift = ScheduleAssignment::leftJoin('shifts as s', 's.id', '=', 'schedule_assignments.shift_id')
            ->select('schedule_assignments.*', 's.name as shift_name', 's.working_hour_start', 's.working_hour_end')
            ->where('employee_id', $attendance->employee_id)->where(function($query) use ($date){
                $query->where('schedule_assignments.start_date', '<=', $date);
                $query->where('schedule_assignments.end_date', '>=', $date);
            })->first();

            //get data time off
            $time_off = TimeOffBalance::select('timeoffs.code as time_off_code','timeoffs.id as time_off_id', 'timeoffs.name as time_off_name')
            ->leftJoin('timeoffs', 'timeoffs.id', '=', 'time_off_balances.timeoff_id')
            ->where('employee_id', $attendance->employee_id)->where(function($query) use ($date){
                $query->where('time_off_balances.start_date', '<=', $date);
                $query->where('time_off_balances.end_date', '>=', $date);
            })->first();

            $overtime = EmployeeRequestOvertime::select('*', DB::raw('sec_to_time(time_to_sec(overtime_before)+time_to_sec(overtime_after)) total_overtime'))
                ->where('employee_id', $attendance->employee_id)
                ->Where(DB::raw('date(date_request)'), $date)->first();
            
            if(isset($attendance->clock_in)){
                $clock_in = substr($attendance->clock_in, 0, 5);
            }else{
                $clock_in = "-";
            }
            
            if(isset($attendance->clock_out)){
                $clock_out = substr($attendance->clock_out, 0, 5);
            }else{
                $clock_out = "-";
            }
            
            $attendance->date            = date('d M Y', strtotime($attendance->created_at));
            $attendance->clock_in        = $clock_in;
            $attendance->clock_out       = $clock_out;
            $attendance->schedule_in     = $shift ? substr($shift->working_hour_start, 0, 5) : '-';
            $attendance->schedule_out    = $shift ? substr($shift->working_hour_end, 0, 5) : '-';
            $attendance->attendance_code = $attendance->attendance_code;
            $attendance->time_off_code   = $time_off ? $time_off->time_off_code : '';
            $attendance->time_off_id     = $time_off ? $time_off->time_off_id : '';
            $attendance->time_off_name   = $time_off ? $time_off->time_off_name : '';
            $attendance->overtime        = '';
            $attendance->shift_id        = $shift ? $shift->shift_id:'';
            $attendance->shift_name      = $shift ? $shift->shift_name:'';
            $attendance->overtime_before = $overtime ? substr($overtime->overtime_before, 0, 5) : '';
            $attendance->break_before    = $overtime ? substr($overtime->break_before, 0, 5) : '';
            $attendance->overtime_after  = $overtime ? substr($overtime->overtime_after, 0, 5) : '';
            $attendance->break_after     = $overtime ? substr($overtime->break_after, 0, 5) : '';
            
        }

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'data' => $attendance
        ]);
    }

    public function attendanceDelete(Request $request){
        $validator = Validator::make($request->all(),[
            "id"=>"required",
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first()
            ]);

        }else{
            $attendance = AttendanceEmployee::find($request->id);
            $attendance->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Data has been deleted'
            ]);
        }
    }

    public function attendanceEditSave(Request $request){

        $param = $request->all();

        if($request->clock_in){
            $param['clock_in'] = 'date_format:H:i';
        }

        if($request->clock_out){
            $param['clock_out'] = 'date_format:H:i';
        }

        if($request->clock_in == '' && $request->clock_out == ''){
            return response()->json([
                'status' => 400,
                'message' => 'Please entry clock in or clock out'
            ]);
        }

        if($request->overtime_before){
            $param['overtime_before'] = 'date_format:H:i';
        }

        if($request->break_before){
            $param['overtime_before'] = 'date_format:H:i';
        }

        if($request->overtime_after){
            $param['overtime_after'] = 'date_format:H:i';
        }

        if($request->break_after){
            $param['overtime_after'] = 'date_format:H:i';
        }

        $validator = Validator::make($param,[
            "id"=>"required",
            "shift_id"=>"required",
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first()
            ]);

        }else{

            $attendance_data = TimeManagement::join('employees','employees.id','attendance_employee.employee_id')
                ->join('attendances','attendances.id','attendance_employee.attendance_id')
                ->select('attendance_employee.*','employees.full_name','attendances.calendar_id')
                ->where('attendance_employee.id', $request->id)->first();

            if($attendance_data){

                //update data attendance
                $upd_attend = TimeManagement::find($request->id);
                $upd_attend->clock_in  = $request->clock_in;
                $upd_attend->clock_out = $request->clock_out;
                $upd_attend->save();

                $date = date('Y-m-d', strtotime($attendance_data->created_at));

                //get data shift
                $schedule = ScheduleAssignment::select('schedule_assignments.*')
                ->where('employee_id', $attendance_data->employee_id)->where(function($query) use ($date){
                    $query->where('schedule_assignments.start_date', '<=', $date);
                    $query->where('schedule_assignments.end_date', '>=', $date);
                })->first();

                if($schedule){
                    $upd_schedule = ScheduleAssignment::where('employee_id', $attendance_data->employee_id)->where(function($query) use ($date){
                        $query->where('schedule_assignments.start_date', '<=', $date);
                        $query->where('schedule_assignments.end_date', '>=', $date);
                    })->update([
                        'shift_id' => $request->shift_id
                    ]);
                    
                }else{
                    return response()->json([
                        'status' => 400,
                        'message' => 'shift id invalid'
                    ]);
                }

                //get data time off
                $time_off = TimeOffBalance::where('employee_id', $attendance_data->employee_id)->where(function($query) use ($date){
                    $query->where('time_off_balances.start_date', '<=', $date);
                    $query->where('time_off_balances.end_date', '>=', $date);
                })->first();


                if($time_off && $request->time_off_id != '' && $request->show_time_off){
                    //update data time off
                    $upd_time_off = TimeOffBalance::where('employee_id', $attendance_data->employee_id)->where(function($query) use ($date){
                        $query->where('start_date', '<=', $date);
                        $query->where('end_date', '>=', $date);
                    })->update([
                        'timeoff_id' => $request->time_off_id
                    ]);
                    
                }elseif(!$time_off && $request->time_off_id != ''  && $request->show_time_off){

                    $last_time_off = TimeOffBalance::where('employee_id', $attendance_data->employee_id)->orderBy('created_at', 'desc')->first();

                    if($last_time_off){
                        $last_balance = $last_time_off->balance_end;
                    }else{
                        $time_off_empl = TimeOffEmployee::where('employee_id', $attendance_data->employee_id)->where(function($query) use ($date){
                            $query->where('start_date', '<=', $date);
                            $query->where('end_date', '>=', $date);
                        })->orderBy('created_at', 'desc')->first();

                        if($time_off_empl){
                            $last_balance = $time_off_empl->input_balance;
                        }else{

                            $shift = TimeOff::find($request->time_off_id)->first();

                            return response()->json([
                                'status' => 400,
                                'message' => 'Fail when update the time off, This employee don\'t have balance '.$shift->name.' . <a href="'.route('timeoff.assign.create').'">Go to time off assignment Page</a>'
                            ]);
                        }
                    }

                    $ins_time_off = new TimeOffBalance;
                    $ins_time_off->timeoff_id    = $request->time_off_id;
                    $ins_time_off->start_date    = $date;
                    $ins_time_off->images        = '[]';
                    $ins_time_off->end_date      = $date;
                    $ins_time_off->employee_id   = $attendance_data->employee_id;
                    $ins_time_off->balance_start = $last_balance;
                    $ins_time_off->balance_end   = $last_balance-1;
                    $ins_time_off->save();

                    $req_id_time_off = $ins_time_off->id;

                    $ins_time_off_log = new StatusRequestTimeOff;
                    $ins_time_off_log->time_off_balances_id = $req_id_time_off;
                    $ins_time_off_log->status               = 'APPROVED';
                    $ins_time_off_log->description          = 'Your overtime request has been approved';
                    $ins_time_off_log->approved_by          = Auth::user()->id;
                    $ins_time_off_log->save();

                }elseif($time_off && !$request->show_time_off){
                    //delete time off
                    TimeOffBalance::where('employee_id', $attendance_data->employee_id)->where(function($query) use ($date){
                        $query->where('start_date', '<=', $date);
                        $query->where('end_date', '>=', $date);
                    })->delete();
                    
                    //delete log time off
                    StatusRequestTimeOff::where('time_off_balances_id',$time_off->id)->delete();
                }

                $overtime = EmployeeRequestOvertime::where('employee_id', $attendance_data->employee_id)->where(DB::raw('date(date_request)'), $date)->first();

                if($overtime && ( 
                    $request->overtime_before != '' || $request->break_before != '' || $request->overtime_after != '' || $request->break_after != '' 
                ) && $request->show_overtime){
                    //update overtime
                    EmployeeRequestOvertime::where('employee_id', $attendance_data->employee_id)->where(DB::raw('date(date_request)'), $date)
                    ->update([
                        'overtime_before'   => $request->overtime_before,
                        'break_before'      => $request->break_before,
                        'overtime_after'    => $request->overtime_after,
                        'break_after'       => $request->break_after,
                        'date_request'      => $overtime->date_request,
                    ]);
                }elseif(!$overtime && (
                    $request->overtime_before != '' || $request->break_before != '' || $request->overtime_after != '' || $request->break_after != '' 
                ) && $request->show_overtime){
                    //insert new overtime
                    $ins_overtime = new EmployeeRequestOvertime;
                    $ins_overtime->employee_id       = $attendance_data->employee_id;
                    $ins_overtime->overtime_before   = $request->overtime_before ?? '';
                    $ins_overtime->break_before      = $request->break_before ?? '';
                    $ins_overtime->overtime_after    = $request->overtime_after ?? '';
                    $ins_overtime->break_after       = $request->break_after ?? '';
                    $ins_overtime->date_request      = $date;
                    $ins_overtime->notes             = '';
                    $ins_overtime->compensation_type = '';
                    $ins_overtime->save();

                    //insert logs status
                    $overtime_req_id = $ins_overtime->id;

                    $ins_overtime_log = new StatusRequestOvertime;
                    $ins_overtime_log->overtime_request_id = $overtime_req_id;
                    $ins_overtime_log->status              = 'APPROVED';
                    $ins_overtime_log->description         = 'Your overtime request has been approved';
                    $ins_overtime_log->approved_by         = Auth::user()->id;
                    $ins_overtime_log->save();
                }elseif(
                    ( 
                        $overtime && (
                        $request->overtime_before == '' || $request->break_before == '' || $request->overtime_after == '' || $request->break_after == '' 
                        )
                    ) || 
                    (
                        $overtime && !$request->show_overtime
                    ))
                {
                    //delete overtime
                    EmployeeRequestOvertime::find($overtime->id)->delete();
                    //delete log overtime
                    StatusRequestOvertime::where('overtime_request_id',$overtime->id)->delete();
                }

                return response()->json([
                    'status' => 200,
                    'message' => 'Data has been updated'
                ]);

            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'id invalid'
                ]);
            }

        }
    }

    public function getTimeOff(Request $request){
        $time_off = TimeOff::select('timeoffs.*')
        ->where('name', 'like', '%'.$request->q.'%')->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'data' => $time_off
        ]);
    }

    public function schedule(Request $request)
    {
        $date = $request->date ?? date('Y-m-d');

        $weeks = $this->get_week($date);

        $prev_week = date ( 'Y-m-d' , strtotime ( '-1 day' , strtotime ( $weeks[0]['date'] ) ) );
        $next_week = date ( 'Y-m-d' , strtotime ( '1 day' , strtotime ( $weeks[6]['date'] ) ) );
        
        return view("admin.time-management.schedule", compact('weeks', 'prev_week', 'next_week'));
    }

    public function ajaxEmployees(Request $request){

        $column = array('full_name');
        $dir  = $request->input('order.0.dir');
        $limit  = $request->input('length');
        $start  = $request->input('start');

        $filter_branch = json_decode($request->_filter_branch??"[]");
        $filter_department = json_decode($request->_filter_department??"[]");
        $filter_position = json_decode($request->_filter_position??"[]");

        //get date
        $date = $request->_date ?? date('Y-m-d');
        
        $weeks = $this->get_week($date);

        $temp = Employee::select('full_name','id');
        $total = $temp->count();
        
        $temp->where('full_name', 'like', '%'.$request->input('search.value').'%');

        if($filter_branch || $filter_department || $filter_position){
            $temp->where(function($query) use ($filter_branch, $filter_department, $filter_position){
                if($filter_branch){
                    $query->orWhereIn('branch_id', $filter_branch);
                }
                if($filter_department){
                    $query->orWhereIn('department_id', $filter_department);
                }
                if($filter_position){
                    $query->orWhereIn('job_position_id', $filter_position);
                }
            });
        }

        $totalFiltered = $temp->count();

        $employees = $temp->orderBy('full_name','asc')
        ->limit($limit)
        ->offset($start)
        ->get();

        foreach ($employees as $row) {

            foreach ($weeks as $week_row) {

                $shift = ScheduleAssignment::leftJoin('shifts as s', 's.id', '=', 'schedule_assignments.shift_id')
                ->select('schedule_assignments.*', 's.name as shift_name', 's.working_hour_start', 's.working_hour_end')
                ->where('employee_id', $row->id)->where(function($query) use ($week_row){
                    $query->where('schedule_assignments.start_date', '<=', $week_row['date']);
                    $query->where('schedule_assignments.end_date', '>=', $week_row['date']);
                })->first();

                if($shift){
                    $template = '<div class="col-shift-area d-flex justify-content-between align-items-center card bg-secondary">
                        <div class="card-body bg-secondary">
                            <strong>'.substr($shift->working_hour_start, 0, 5).' - '.substr($shift->working_hour_end, 0, 5).'</strong> <br> '.$shift->shift_name.'
                            <div class="col-shift">
                                <button type="button" data-toggle="modal" data-target="#changeShiftModal" class="btn btn-outline-hover-primary btn-sm btn-icon btn-shift-option" data-toggle="tooltip" data-placement="top" title="Change Shift" onclick="changeShift('.$shift->shift_id.',\''.$week_row['date'].'\','.$row->id.')"><i class="fa fa-edit"></i></button>
                                <button type="button" data-toggle="modal" data-target="#confirmDeleteShiftModal" class="btn btn-outline-hover-danger btn-sm btn-icon btn-shift-option" data-toggle="tooltip" data-placement="top" title="Delete Shift" onclick="deleteShift('.$shift->shift_id.',\''.$week_row['date'].'\','.$row->id.')"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>';
                }else{
                    $template = '<div class="col-shift-area d-flex justify-content-between align-items-center card">
                        <div class="card-body">
                            <button onclick="changeShift(null,\''.$week_row['date'].'\','.$row->id.')" type="button" data-toggle="modal" data-target="#changeShiftModal" class="btn btn-outline-hover-primary btn-sm btn-icon btn-shift-option" data-toggle="tooltip" data-placement="top" title="Change Shift" ><i class="fa fa-plus"></i></button>
                        </div>
                    </div>';
                }
                $row[$week_row['day_name']] = $template;

            }

            $row['actions'] = '';
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFiltered,
            "data" => $employees
        );
        echo json_encode($json_data);
    }

    private function get_week($date){
        $weeks[] = ['day_name' => 'mon', 'date' => date("Y-m-d", strtotime('monday this week', strtotime($date))) ];
        $weeks[] = ['day_name' => 'tue', 'date' => date("Y-m-d", strtotime('tuesday this week', strtotime($date))) ];
        $weeks[] = ['day_name' => 'wed', 'date' => date("Y-m-d", strtotime('wednesday this week', strtotime($date))) ];
        $weeks[] = ['day_name' => 'thu', 'date' => date("Y-m-d", strtotime('thursday this week', strtotime($date))) ];
        $weeks[] = ['day_name' => 'fri', 'date' => date("Y-m-d", strtotime('friday this week', strtotime($date))) ];
        $weeks[] = ['day_name' => 'sat', 'date' => date("Y-m-d", strtotime('saturday this week', strtotime($date))) ];
        $weeks[] = ['day_name' => 'sun', 'date' => date("Y-m-d", strtotime('sunday this week', strtotime($date))) ];

        return $weeks;
    }

    public function getFilterSchedule(Request $request){

        $data['branches'] = Branch::orderBy('name','asc')->get(); 
        $data['department'] = Department::orderBy('name','asc')->get(); 
        $data['position'] = JobPosition::orderBy('name','asc')->get(); 

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'data' => $data
        ]);
    }

    public function getShiftList(Request $request){
        $data = Shift::orderBy('name','asc')->where('name','like','%'.$request->q.'%')->get();

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'data' => $data
        ]);
    }

    public function changeShift(Request $request){
        
        $validator = Validator::make($request->all(),[
            "shift_id"=>"required",
            "date"=>"required",
            "employee_id"=>"required"
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first()
            ]);

        }else{

            $shift = ScheduleAssignment::leftJoin('shifts as s', 's.id', '=', 'schedule_assignments.shift_id')
                ->select('schedule_assignments.*', 's.name as shift_name', 's.working_hour_start', 's.working_hour_end')
                ->where('employee_id', $request->employee_id)->where(function($query) use ($request){
                    $query->where('schedule_assignments.start_date', '<=', $request->date);
                    $query->where('schedule_assignments.end_date', '>=', $request->date);
                })->first();

            if($shift){

                $split_left = false;
                $split_right = false;

                $plus_date = date ( 'Y-m-d' , strtotime ( '1 day' , strtotime ( $request->date ) ) );
                $min_date = date ( 'Y-m-d' , strtotime ( '-1 day' , strtotime ( $request->date ) ) );

                //get difference date
                $date1 = new DateTime($shift->start_date);
                $date2 = new DateTime($min_date);
                $interval = $date1->diff($date2);
                $diff_left = (int)str_replace('+','',$interval->format('%R%a'));

                if($diff_left>=0){
                    $split_left = true;
                }

                //get difference date
                $date1 = new DateTime($plus_date);
                $date2 = new DateTime($shift->end_date);
                $interval = $date1->diff($date2);
                $diff_right = (int)str_replace('+','',$interval->format('%R%a'));

                if($diff_right>=0){
                    $split_right = true;
                }

                //split old data
                ScheduleAssignment::where('employee_id',$request->employee_id)->where(function($query) use ($request){
                    $query->where('schedule_assignments.start_date', '<=', $request->date);
                    $query->where('schedule_assignments.end_date', '>=', $request->date);
                })->delete();

                if($split_left){
                    $assignment = new ScheduleAssignment;
                    $assignment->shift_id = $shift->shift_id;
                    $assignment->employee_id = $shift->employee_id;
                    $assignment->start_date = $shift->start_date;
                    $assignment->end_date = $min_date;
                    $assignment->created_by = Auth::user()->id;
                    $assignment->save();
                }
                
                if($split_right){
                    $assignment = new ScheduleAssignment;
                    $assignment->shift_id = $shift->shift_id;
                    $assignment->employee_id = $shift->employee_id;
                    $assignment->start_date = $plus_date;
                    $assignment->end_date = $shift->end_date;
                    $assignment->created_by = Auth::user()->id;
                    $assignment->save();
                }

                $assignment = new ScheduleAssignment;
                $assignment->shift_id = $request->shift_id;
                $assignment->employee_id = $request->employee_id;
                $assignment->start_date = $request->date;
                $assignment->end_date = $request->date;
                $assignment->created_by = Auth::user()->id;
                $assignment->save();
                
            }else{
                
                $assignment = new ScheduleAssignment;
                $assignment->shift_id = $request->shift_id;
                $assignment->employee_id = $request->employee_id;
                $assignment->start_date = $request->date;
                $assignment->end_date = $request->date;
                $assignment->created_by = Auth::user()->id;
                $assignment->save();
            }


            return response()->json([
                'status' => 200,
                'message' => 'Shift has been changed'
            ]);
        }
    }

    public function deleteShift(Request $request){
        
        $validator = Validator::make($request->all(),[
            "shift_id"=>"required",
            "date"=>"required",
            "employee_id"=>"required"
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first()
            ]);

        }else{

            $shift = ScheduleAssignment::leftJoin('shifts as s', 's.id', '=', 'schedule_assignments.shift_id')
                ->select('schedule_assignments.*', 's.name as shift_name', 's.working_hour_start', 's.working_hour_end')
                ->where('employee_id', $request->employee_id)->where(function($query) use ($request){
                    $query->where('schedule_assignments.start_date', '<=', $request->date);
                    $query->where('schedule_assignments.end_date', '>=', $request->date);
                })->first();

            if($shift){

                $split_left = false;
                $split_right = false;

                $plus_date = date ( 'Y-m-d' , strtotime ( '1 day' , strtotime ( $request->date ) ) );
                $min_date = date ( 'Y-m-d' , strtotime ( '-1 day' , strtotime ( $request->date ) ) );

                //get difference date
                $date1 = new DateTime($shift->start_date);
                $date2 = new DateTime($min_date);
                $interval = $date1->diff($date2);
                $diff_left = (int)str_replace('+','',$interval->format('%R%a'));

                if($diff_left>=0){
                    $split_left = true;
                }

                //get difference date
                $date1 = new DateTime($plus_date);
                $date2 = new DateTime($shift->end_date);
                $interval = $date1->diff($date2);
                $diff_right = (int)str_replace('+','',$interval->format('%R%a'));

                if($diff_right>=0){
                    $split_right = true;
                }

                //split old data
                ScheduleAssignment::where('employee_id',$request->employee_id)->where(function($query) use ($request){
                    $query->where('schedule_assignments.start_date', '<=', $request->date);
                    $query->where('schedule_assignments.end_date', '>=', $request->date);
                })->delete();

                if($split_left){
                    $assignment = new ScheduleAssignment;
                    $assignment->shift_id = $shift->shift_id;
                    $assignment->employee_id = $shift->employee_id;
                    $assignment->start_date = $shift->start_date;
                    $assignment->end_date = $min_date;
                    $assignment->save();
                }
                
                if($split_right){
                    $assignment = new ScheduleAssignment;
                    $assignment->shift_id = $shift->shift_id;
                    $assignment->employee_id = $shift->employee_id;
                    $assignment->start_date = $plus_date;
                    $assignment->end_date = $shift->end_date;
                    $assignment->save();
                }
                
            }else{
                
                ScheduleAssignment::where('employee_id',$request->employee_id)->where(function($query) use ($request){
                    $query->where('schedule_assignments.start_date', '<=', $request->date);
                    $query->where('schedule_assignments.end_date', '>=', $request->date);
                })->delete();
            }


            return response()->json([
                'status' => 200,
                'message' => 'Shift has been deleted'
            ]);
        }
    }

    public function getEmployee(Request $request){
        
        $q = $request->q ?? '';
        $filter_branch = json_decode($request->_filter_branch??"[]");
        $filter_department = json_decode($request->_filter_department??"[]");
        $filter_position = json_decode($request->_filter_position??"[]");

        $temp = Employee::select(
            'employees.id', 'employees.full_name', 'jp.name as job_position_name', 'dp.name as department_name', 'b.name as branch_name',
            'employees.branch_id', 'employees.department_id', 'employees.job_position_id'
        );

        if($filter_branch || $filter_department || $filter_position){
            $temp->where(function($query) use ($filter_branch, $filter_department, $filter_position){
                if($filter_branch){
                    $query->orWhereIn('employees.branch_id', $filter_branch);
                }
                if($filter_department){
                    $query->orWhereIn('employees.department_id', $filter_department);
                }
                if($filter_position){
                    $query->orWhereIn('employees.job_position_id', $filter_position);
                }
            });
        }

        $employees = $temp->where('employees.full_name', 'like', '%'.$q.'%')
        ->leftJoin('job_position as jp', 'jp.id', '=', 'employees.job_position_id')
        ->leftJoin('departments as dp', 'dp.id', '=', 'employees.department_id')
        ->leftJoin('branches as b', 'b.id', '=', 'employees.department_id')
        ->orderBy('full_name','asc')->get();

        return response()->json([
            'status' => 200,
            'message' => 'OK',
            'data' => $employees
        ]);

    }

    public function assignBulk(Request $request){

        $rules = [
            "employees"=>"required|array",
            "shift_id"=>"required",
            "days"=>"required|array",
            "start_date"=>"required|date"
        ];

        if($request->end_date != null && $request->end_date != ''){
            $rules['end_date'] = 'date|after:start_date';
        }

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first()
            ]);

        }else{

            if($request->end_date == '' || $request->end_date == null){
                $request->end_date = $request->start_date;
            }

            $period = $this->getDatesFromRange($request->start_date, $request->end_date);

            foreach($request->employees as $employee_id){

                $is_valid_employee = Employee::find($employee_id)->first();

                if($is_valid_employee){

                    foreach ($period as $date) {

                        $assign_data = ScheduleAssignment::where('employee_id', $employee_id)->where(function($query) use ($date){
                            $query->where('start_date', '<=', $date);
                            $query->where('end_date', '>=', $date);
                        })->first();

                        if(!$assign_data){

                            //get day name of date
                            $date_tmp = strtotime($date);
                            $day_name = substr(strtolower(date('l', $date_tmp)), 0, 3);

                            if(in_array($day_name, $request->days)){
                             
                                //insert new assignment shift
                                $assign = new ScheduleAssignment;
                                $assign->employee_id = $employee_id;
                                $assign->shift_id = $request->shift_id;
                                $assign->start_date = $date;
                                $assign->end_date = $date;
                                $assign->created_by = Auth::user()->id;
                                $assign->save();

                            }

                        }else{

                            //update old assignment shift
                            $assign = ScheduleAssignment::where('employee_id', $employee_id)->where(function($query) use ($date){
                                $query->where('start_date', '<=', $date);
                                $query->where('end_date', '>=', $date);
                            })->update([ 'shift_id' => $request->shift_id ]);

                        }
                    }

                }

            }

            return response()->json([
                'status' => 200,
                'message' => 'Assign shift to employee has been successfully'
            ]);
        }
    }

    private function getDatesFromRange($start, $end, $format = 'Y-m-d') {
        $array = array();
        $interval = new DateInterval('P1D');
    
        $realEnd = new DateTime($end);
        $realEnd->add($interval);
    
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
    
        foreach($period as $date) { 
            $array[] = $date->format($format); 
        }
    
        return $array;
    }

    public function getDailyDataAttendance(Request $request){

        $date = $request->date?$request->date:date('Y-m-d');

        $query = "SELECT 
        count(employee_id) total_employee, 
        coalesce(sum(if(clock_in <= schedule_in , 1, 0)), 0) total_on_time, 
        coalesce(sum(if(clock_in > schedule_in , 1, 0)), 0) total_late_in,
        coalesce(sum(if(attendance_code <> 'H' , 1, 0)), 0) total_absent,
        coalesce(sum(if(time_off_code <> '' , 1, 0)), 0) total_time_off,
        coalesce(sum(if(shift_name = 'dayoff' , 1, 0)), 0) total_day_off,
        coalesce(sum(if(clock_in is null , 1, 0)), 0) total_no_clock_in
        FROM (
            SELECT employee_id, clock_in, sche.working_hour_start as schedule_in, sche.shift_name, created_at, ae.attendance_code, cc.time_off_code FROM `attendance_employee` as ae
            LEFT JOIN (
                SELECT sa.start_date, sa.end_date, sa.employee_id as employee_id2, s.name as shift_name, s.working_hour_start, s.working_hour_end 
                FROM schedule_assignments as sa 
                LEFT JOIN shifts as s ON s.id = sa.shift_id
            ) as sche ON sche.employee_id2 = ae.employee_id AND ( (date(ae.created_at) >= sche.start_date AND date(ae.created_at) <= sche.end_date) )
            LEFT JOIN (
                SELECT c.employee_id as employee_id3, c.start_date, c.end_date, t.code as time_off_code
                FROM time_off_employees as c
                LEFT JOIN timeoffs as t ON t.id = c.id
            ) as cc ON cc.employee_id3 = ae.employee_id AND ( (date(ae.created_at) >= cc.start_date AND date(ae.created_at) <= cc.end_date) )
        ) as root  WHERE date(root.created_at) BETWEEN ? AND ?
        ORDER BY
            root.created_at";

        $data = DB::select($query,[$date, $date])[0];
        $data->today = date('d M Y', strtotime($date));

        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'data' => $data
        ]);
    }
}
