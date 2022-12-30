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
        $column = array('full_name','employee_id','date','clock_in','clock_out','actions');
        $total  = null;
        $boot   = null;
        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $column[$request->input('order.0.column')];
        $dir  = $request->input('order.0.dir');
        $temp = TimeManagement::join('employees','employees.id','attendance_employee.employee_id')
                ->join('attendances','attendances.id','attendance_employee.attendance_id')
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
                ->where('employee_id', $row->employee_id)->Where(function($query) use ($date){
                    $query->where('start_date', '<=', $date);
                    $query->where('end_date', '>=', $date);
                })->first();

                //get data time off
                $time_off = Izin::select('clearances.timeoff_code', 'clearances.type_leave')
                ->where('employee_id', $row->employee_id)->Where(function($query) use ($date){
                    $query->where('start_at', '<=', $date);
                    $query->where('end_at', '>=', $date);
                })->first();
                
                if(isset($row->clock_in)){
                    $clock_in = $row->clock_in;
                }else{
                    $clock_in = "-";
                }
                if(isset($row->clock_out)){
                    $clock_out = $row->clock_out;
                }else{
                    $clock_out = "-";
                }
                // if(isset($row->calendar_id)){
                //     $calendar_id = $row->calendar_id;
                // }else{
                //     $calendar_id = "-";
                // }
                $name = $row->full_name;
                $edit     ='<a href="'.route('employee.account',['id' => $row->employee_id]).'"  class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                                <i class="la la-eye"></i>
                            </a>';
                $hapus ='<a href="'.route('employee.destroy',['id' => $row->id]).'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">
                                <i class="la flaticon-delete"></i>
                            </a>';
                $obj['fullname']            = $name;
                $obj['employee_id']         = $row->employee_id;
                $obj['date']                = date('d M Y', strtotime($row->created_at));
                $obj['clock_in']            = $clock_in;
                $obj['clock_out']           = $clock_out;
                $obj['schedule_in']         = $shift ? substr($shift->working_hour_start, 0, 5) : '-';
                $obj['schedule_out']        = $shift ? substr($shift->working_hour_end, 0, 5) : '-';
                $obj['attendance_code']     = $row->attendance_code;
                $obj['timeoff_code']     = $time_off ? $time_off->timeoff_code : '';
                $obj['type_leave_name']     = $time_off ? $time_off->type_leave : '';
                $obj['overtime']            = '';
                $obj['actions']             = $edit." ".$hapus;
                $obj['shift_name']          = $shift ? $shift->name:'';
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
            $temp->Where(function($query) use ($filter_branch, $filter_department, $filter_position){
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
                ->where('employee_id', $row->id)->Where(function($query) use ($week_row){
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

        $data = Shift::orderBy('name','asc')->get();

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
                    $query->where('start_date', '<=', $request->date);
                    $query->where('end_date', '>=', $request->date);
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
                    $query->where('start_date', '<=', $request->date);
                    $query->where('end_date', '>=', $request->date);
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
                    $query->where('start_date', '<=', $request->date);
                    $query->where('end_date', '>=', $request->date);
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
                    $query->where('start_date', '<=', $request->date);
                    $query->where('end_date', '>=', $request->date);
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
                    $query->where('start_date', '<=', $request->date);
                    $query->where('end_date', '>=', $request->date);
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
            $temp->Where(function($query) use ($filter_branch, $filter_department, $filter_position){
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
        coalesce(sum(if(timeoff_code <> '' , 1, 0)), 0) total_time_off,
        coalesce(sum(if(shift_name = 'dayoff' , 1, 0)), 0) total_day_off,
        coalesce(sum(if(clock_in is null , 1, 0)), 0) total_no_clock_in
        FROM (
            SELECT employee_id, clock_in, sche.working_hour_start as schedule_in, sche.shift_name, created_at, ae.attendance_code, cc.timeoff_code FROM `attendance_employee` as ae
            LEFT JOIN (
                SELECT sa.start_date, sa.end_date, sa.employee_id as employee_id2, s.name as shift_name, s.working_hour_start, s.working_hour_end 
                FROM schedule_assignments as sa 
                LEFT JOIN shifts as s ON s.id = sa.shift_id
            ) as sche ON sche.employee_id2 = ae.employee_id AND ( (date(ae.created_at) >= sche.start_date AND date(ae.created_at) <= sche.end_date) )
            LEFT JOIN (
                SELECT c.employee_id as employee_id3, c.start_at, c.end_at, c.timeoff_code
                FROM clearances as c
            ) as cc ON cc.employee_id3 = ae.employee_id AND ( (date(ae.created_at) >= cc.start_at AND date(ae.created_at) <= cc.end_at) )
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
