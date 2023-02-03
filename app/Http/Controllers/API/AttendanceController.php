<?php

namespace App\Http\Controllers\API;

use App\Attendance;
use App\Calendar;
use App\Employee;
use App\AttendanceEmployee;
use App\Branch;
use App\TimeOffBalance;
use App\EmployeeRequestOvertime;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendaceResource;
use App\Http\Resources\AttendanceCollection;
use App\Http\Resources\ShiftResource;
use App\Shift;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\ScheduleAssignment;
use App\EmployeeRequestAttendance;
use App\StatusRequestAttendance;
use Validator;
use DB;
use DatePeriod;
use DateTime;
use DateInterval;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $dt = Carbon::now();
        // $today = $dt->format('Y-m-d');
        // $employee = $request->user()->employee;

        // $isAttendanceToday = Attendance::with('employees')
        //     ->whereHas('employees', function (Builder $query) use ($today, $employee) {
        //         $query->where('employees.id', $employee->id)
        //             ->where('attendances.date', $today);
        //     })->get();

        // $test = Employee::find($employee->id)->attendances()
        //     ->where('date', $today)
        //     ->get();

        // // dd($test);
        // // foreach ($isAttendanceToday->employees as $value) {
        // //     dump($value->pivot);
        // // }




        // // return $isAttendanceToday;
        // // return AttendaceResource::collection($isAttendanceToday);
        // return new AttendanceCollection(true, 'success', $isAttendanceToday);
    }
    

    public function requestList(Request $request){
        $rules = [
            "month"=>"required|date_format:Y-m"
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => []
            ]);

        }else{

            $data = EmployeeRequestAttendance::where('employee_id', $request->user()->employee->id)
            ->where(DB::raw("date_format(created_at, '%Y-%m')"), '=', $request->month)
            ->select(
                'id',
                DB::raw('date(created_at) as date'),
                DB::raw("date_format(clock_in,'%H:%i') as clock_in"),
                DB::raw("date_format(clock_out,'%H:%i') as clock_out"),
                DB::raw('(SELECT status FROM status_request_attendance WHERE employee_request_attendance_id = employee_request_attendance.id ORDER BY created_at DESC LIMIT 1) as status')
            )->get();

            return response()->json([
                'status' => 200,
                'message' => 'Ok',
                'data' => $data
            ]);
        }
    }

    public function requestDetail(Request $request){
        $rules = [
            "id"=>"required"
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => []
            ]);

        }else{

            $data = EmployeeRequestAttendance::leftJoin('employees', 'employees.id','=','employee_request_attendance.employee_id')
            ->leftJoin('job_position', 'job_position.id','=','employees.job_position_id')
            ->where('employee_request_attendance.employee_id', $request->user()->employee->id)
            ->where('employee_request_attendance.id',$request->id)
            ->select(
                'employee_request_attendance.id',
                'employees.full_name',
                'job_position.name as position_name',
                'date as request_date',
                DB::raw('date(employee_request_attendance.created_at) as date'),
                DB::raw("date_format(clock_in, '%H:%i') as clock_in"),
                DB::raw("date_format(clock_out, '%H:%i') as clock_out"),
                'note',
            )->first();

            if($data){

                //get last log status
                $last_log = StatusRequestAttendance::where('employee_request_attendance_id', $request->id)->orderBy('created_at','desc')
                ->select(DB::raw('date(created_at) as created_at_in_date'),'status')->limit(1)->first();

                //get data schedule
                $schedule = ScheduleAssignment::leftJoin('shifts as s', 's.id', '=', 'schedule_assignments.shift_id')
                ->select('schedule_assignments.*', 's.name as shift_name', 's.working_hour_start', 's.working_hour_end', 's.show_in_request')
                ->where('employee_id', $request->user()->employee->id)->Where(function($query) use ($data){
                    $query->where('schedule_assignments.start_date', '<=', $data->date);
                    $query->where('schedule_assignments.end_date', '>=', $data->date);
                })->first();

                $logs_status = StatusRequestAttendance::where('employee_request_attendance_id', $data->id)->orderBy('created_at','desc')
                ->leftJoin('employees as e','e.id','=','status_request_attendance.approved_by')
                ->leftJoin('job_position as jp', 'jp.id','=','e.job_position_id')
                ->select('status','status_request_attendance.created_at','e.full_name as approved_by','jp.name as position_name','description')->get();

                $data->shift_name   = $schedule ? $schedule->shift_name:'-';
                $data->schedule_in  = $schedule ? $schedule->working_hour_start:'-';
                $data->schedule_out = $schedule ? $schedule->working_hour_end:'-';
                $data->status       = $last_log ? $last_log->status : '-';
                $data->approved_at  = $last_log ? $last_log->created_at_in_date : '-';
                $data->logs_status  = $logs_status;

                return response()->json([
                    'status' => 200,
                    'message' => 'Ok',
                    'data' => $data
                ]);
            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'id invalid',
                    'data' => null
                ]);
            }
        }
    }

    public function request(Request $request)
    {
        $rules = [
            "date"=>"required|date_format:Y-m-d"
        ];

        if($request->clock_in){
            $rules['clock_in'] = "required|date_format:H:i";
        }

        if($request->clock_out){
            $rules['clock_out'] = "required|date_format:H:i";
        }

        if(!$request->clock_out && !$request->clock_in){
            return response()->json([
                'status' => 400,
                'message' => 'clock in or clock out is required',
            ]);
        }

        $validator = Validator::make($request->all(),$rules);

        $employee_id = $request->user()->employee->id;

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
            ]);

        }else{

            //is already exist 
            $is_exist = EmployeeRequestAttendance::where('employee_id', $employee_id)->where('date', $request->date)->first();

            if($is_exist){
                return response()->json([
                    'status' => 400,
                    'message' => 'you have already submitted on the same date before',
                ]);
            }else{
        
                $req_attendance = new EmployeeRequestAttendance;
                $req_attendance->employee_id = $employee_id;
                $req_attendance->date        = $request->date;
                $req_attendance->clock_in    = $request->clock_in;
                $req_attendance->clock_out   = $request->clock_out;
                $req_attendance->note        = $request->note;
                $req_attendance->save();

                $req_id = $req_attendance->id;

                $req_status = new StatusRequestAttendance;
                $req_status->employee_request_attendance_id = $req_id;
                $req_status->status                         = 'REQUEST';
                $req_status->description                    = 'Waiting for approval';
                $req_status->save();
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Request attendance has been successfully',
                ]);
            }
        }

    }

    public function cancelRequest(Request $request){

        $rules = [
            "employee_request_attendance_id"=>"required"
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => null
            ]);

        }else{

            //check last status
            $logs_status = StatusRequestAttendance::where('employee_request_attendance_id', $request->employee_request_attendance_id)
                ->orderBy('created_at','desc')->first();

            if($logs_status){
                if($logs_status->status == 'REQUEST'){
                
                    //delete status CANCEL
                    StatusRequestAttendance::where('employee_request_attendance_id', $request->employee_request_attendance_id)->where('status','CANCELED')->delete();
    
                    //create canceled status
                    $ins_log = new StatusRequestAttendance;
                    $ins_log->employee_request_attendance_id = $request->employee_request_attendance_id;
                    $ins_log->status              = 'CANCELED';
                    $ins_log->description         = 'Request has been canceled';
                    $ins_log->save();

                    return response()->json([
                        'status' => 200,
                        'message' => 'Success, Your attendance request has been canceled'
                    ]);
    
                }else{
                    return response()->json([
                        'status' => 400,
                        'message' => 'Cancel request can only if the status is REQUEST'
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'Failed, employee_request_attendance_id invalid'
                ]);
            }


        }

    }

    public function getDistance($latitude, $longitude, $employee){
        $employee_longitude=  $longitude;
        $employee_latitude= $latitude;

        $branch=Branch::find($employee->branch_id);
        $branch_longitude=$branch->longitude;
        $branch_latitude=$branch->latitude;

        $dLat = deg2rad($employee_latitude-$branch_latitude);
        $dLon = deg2rad($employee_longitude-$branch_longitude);

        $radius = 6371;
        $a = sin($dLat/2) * sin($dLat/2) +cos(deg2rad($branch_latitude)) * cos(deg2rad($employee_latitude)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = round(($radius * $c)/1000);
        return $distance;
    }

    public function clockIn(Request $request)
    {
        $rules = [
            "date"=>"required|date_format:Y-m-d",
            "clock_in" => "required|date_format:H:i",
            "latitude" => "required",
            "image" => "required"
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => null
            ]);

        }else{

            $dt = Carbon::now();
            $today = $dt->format('Y-m-d');
            $employee = $request->user()->employee;
            $radius = 50;

            $attendaceEmployee = new AttendanceEmployee;
            $isClockInToday = $attendaceEmployee->where('employee_id', $employee->id)->where(DB::raw('date(created_at)'), $today)->where('attendance_type','clock in')->first();

            $distance = $this->getDistance($request->latitude, $request->longitude,$employee);
            if($distance < $radius){
                if ($isClockInToday) {

                    return response()->json([
                        'status' => 400,
                        'message' => "You cannot attend twice",
                    ]);

                } else {
                    $attendaceEmployee->attendance_type = 'clock in';
                    $attendaceEmployee->clock_in = $request->clock_in;
                    $attendaceEmployee->latitude = $request->latitude;
                    $attendaceEmployee->longitude = $request->longitude;
                    $attendaceEmployee->note = $request->note;
                    $attendaceEmployee->image = $request->image;
                    $attendaceEmployee->employee_id = $employee->id;
                    $attendaceEmployee->attendance_id = 0;
                    $attendaceEmployee->attendance_code = 'H';
                    $attendaceEmployee->save();

                    return response()->json([
                        'status' => 200,
                        'message' => 'You have attend',
                    ]);
                }
            }
            else{
                return response()->json(['status'=> 200 ,'message'=> 'radius exceeded, you cannot clock in']);
            }
        }
    }

    public function clockOut(Request $request)
    {

        $rules = [
            "date"=>"required|date_format:Y-m-d",
            "clock_out" => "required|date_format:H:i",
            "latitude" => "required",
            "image" => "required"
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => null
            ]);

        }else{

            $dt = Carbon::now();
            $today = $dt->format('Y-m-d');
            $yesterday = Carbon::parse('Now -1 days');
            $employee = $request->user()->employee;
            $radius = 50;

            $attendaceEmployee = new AttendanceEmployee;
            $isClockInToday = $attendaceEmployee->where('employee_id', $employee->id)->where(DB::raw('date(created_at)'), $today)->where('attendance_type','clock in')->first();
            $isClockOutToday = $attendaceEmployee->where('employee_id', $employee->id)->where(DB::raw('date(created_at)'), $today)->where('attendance_type','clock out')->first();

            $isClockInYesterday = $attendaceEmployee->where('employee_id', $employee->id)->where(DB::raw('date(created_at)'), $yesterday)->where('attendance_type','clock in')->first();
            $isClockOutYesterday = $attendaceEmployee->where('employee_id', $employee->id)->where(DB::raw('date(created_at)'), $yesterday)->where('attendance_type','clock out')->first();

            $distance = $this->getDistance($request->latitude, $request->longitude,$employee);
            if($distance < $radius){
                if (($isClockInToday && !$isClockOutToday) || ($isClockInYesterday && !$isClockOutYesterday)) {

                    $attendaceEmployee->attendance_type = 'clock out';
                    $attendaceEmployee->clock_out = $request->clock_out;
                    $attendaceEmployee->latitude = $request->latitude;
                    $attendaceEmployee->longitude = $request->longitude;
                    $attendaceEmployee->note = $request->note;
                    $attendaceEmployee->image = $request->image;
                    $attendaceEmployee->employee_id = $employee->id;
                    $attendaceEmployee->attendance_id = 0;
                    $attendaceEmployee->attendance_code = 'H';
                    $attendaceEmployee->save();

                    return response()->json([
                        'status' => 200,
                        'message' => "Thank you for attendance and be careful on the way",
                    ]);

                } elseif((!$isClockInToday && !$isClockOutToday) || (!$isClockInYesterday && !$isClockOutYesterday)) {
                    return response()->json([
                        'status' => 400,
                        'message' => "Please clock in first",
                    ]);
                } elseif(($isClockInToday && $isClockOutToday) || ($isClockInYesterday && $isClockOutYesterday)) {
                    return response()->json([
                        'status' => 400,
                        'message' => "You cannot clock out twice",
                    ]);
                }
            }
            else{
                return response()->json(['status'=> 200 ,'message'=> 'radius exceeded, you cannot clock out']);
            }
        }

    }

    public function getScheduleByDate(Request $request)
    {

        $rules = [];

        if (!empty($request->date)) {
            $rules = [
                "date"=>"date_format:Y-m-d"
            ];
        }

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => null
            ]);

        }else{
            $dt = Carbon::now();
            $today = $dt->format('Y-m-d');
            $date = $request->date;

            if (empty($date)) {
                $date = $today;
            }

            $shift = ScheduleAssignment::leftJoin('shifts as s', 's.id', '=', 'schedule_assignments.shift_id')
            ->select('schedule_assignments.*', 's.name as shift_name', 's.working_hour_start', 's.working_hour_end', 's.show_in_request')
            ->where('employee_id', $request->user()->employee->id)->Where(function($query) use ($date){
                $query->where('schedule_assignments.start_date', '<=', $date);
                $query->where('schedule_assignments.end_date', '>=', $date);
            })->first();

            if($shift){
                $shift->working_hour_start = substr($shift->working_hour_start, 0, 5);
                $shift->working_hour_end = substr($shift->working_hour_end, 0, 5);
            }


            if($shift){
                return response()->json([
                    'status' => 200,
                    'message' => 'Ok',
                    'data' => $shift
                ]);
            }else{
                return response()->json([
                    'status' => 200,
                    'message' => 'Schedule not available',
                    'data' => null
                ]);
            }

        }
    }

    public function getAttendanceHistory(Request $request){

        $rules = [
            "start_date"=>"required|date_format:Y-m-d",
            "end_date"=>"required|date_format:Y-m-d"
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => null
            ]);

        }else{

            $data = AttendanceEmployee::select('*',DB::raw('substring(clock_in, 1, 5) as clock_in'), DB::raw('substring(clock_out, 1, 5) as clock_out'))->where('employee_id', $request->user()->employee->id)->Where(function($query) use ($request){
                $query->where(DB::raw('date(created_at)'), '>=', $request->start_date);
                $query->where(DB::raw('date(created_at)'), '<=', $request->end_date);
            })->orderBy('created_at','asc')->get();

            return response()->json([
                'status' => 200,
                'message' => 'Ok',
                'data' => $data
            ]);

        }

    }

    // public function getAttendanceEmployeeByPivotId(Request $request)
    // {
    //     $pivotId = $request->query('id');
    //     $employeeId = $this->getEmployeeId($request);

    //     $employee = Employee::find($employeeId);

    //     $attendanceEmployeeByPivotId = $employee->attendances()->having('pivot_id', $pivotId)->first();

    //     return $attendanceEmployeeByPivotId;
    // }

    public function getAttendanceHistoryByMonth(Request $request)
    {
        $rules = [
            "month"=>"required|date_format:Y-m"
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => []
            ]);

        }else{

            \DB::statement("SET SQL_MODE=''");//this is the trick use it just before your query

            $data = AttendanceEmployee::select(DB::raw("date(created_at) as date"))
            ->where('employee_id', $request->user()->employee->id)
            ->where(DB::raw("date_format(created_at, '%Y-%m')"), '=', $request->month)
            ->groupBy(DB::raw("date(created_at)"))
            ->orderBy('created_at','asc')->get();

            foreach ($data as $row) {
                $row->detail = AttendanceEmployee::select('*',DB::raw('substring(clock_in, 1, 5) as clock_in'), DB::raw('substring(clock_out, 1, 5) as clock_out'))
                ->where('employee_id', $request->user()->employee->id)
                ->where(DB::raw("date(created_at)"), $row->date)
                ->orderBy('created_at','asc')->get();

                foreach ($row->detail as $sub_row) {
                    if($sub_row->attendance_type == 'clock in'){
                        $row->clock_in = $sub_row->clock_in;
                        $row->clock_out = '-';
                    }elseif($sub_row->attendance_type == 'clock out'){
                        $row->clock_out = $sub_row->clock_out;
                    }else{
                        $row->clock_in = '-';
                        $row->clock_out = '-';
                    }
                }
            }

            return response()->json([
                'status' => 200,
                'message' => 'Ok',
                'data' => $data
            ]);
        }
    }

    private function getEmployeeId(Request $request)
    {
        return $request->user()->employee->id;
    }

    public function logs(Request $request)
    {
        $rules = [
            "month"=>"required|date_format:Y-m"
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => []
            ]);

        }else{

            $last_month = date('Y-m', strtotime($request->month." -1 month"));

            $dates = $this->getDatesFromRange($last_month.'-25', $request->month.'-26');

            foreach ($dates as $key => $row) {
                //attendance
                $attendance = AttendanceEmployee::select('*',DB::raw('substring(clock_in, 1, 5) as clock_in'), DB::raw('substring(clock_out, 1, 5) as clock_out'))
                ->where('employee_id', $request->user()->employee->id)
                ->where(DB::raw("date(created_at)"), $row['date'])
                ->orderBy('created_at','asc')->get();

                //get data shift
                $shift = ScheduleAssignment::leftJoin('shifts as s', 's.id', '=', 'schedule_assignments.shift_id')
                ->select('schedule_assignments.*', 's.name as shift_name', 's.working_hour_start', 's.working_hour_end')
                ->where('employee_id', $request->user()->employee->id)->where(function($query) use ($row){
                    $query->where('schedule_assignments.start_date', '<=', $row['date']);
                    $query->where('schedule_assignments.end_date', '>=', $row['date']);
                })->first();

                //get data time off
                $time_off = TimeOffBalance::select('timeoffs.code as time_off_code','timeoffs.id as time_off_id', 'timeoffs.name as time_off_name')
                ->leftJoin('timeoffs', 'timeoffs.id', '=', 'time_off_balances.timeoff_id')
                ->where('employee_id', $request->user()->employee->id)->where(function($query) use ($row){
                    $query->where('time_off_balances.start_date', '<=', $row['date']);
                    $query->where('time_off_balances.end_date', '>=', $row['date']);
                })->first();

                $overtime = EmployeeRequestOvertime::select('*', DB::raw('sec_to_time(time_to_sec(overtime_before)+time_to_sec(overtime_after)) as total_overtime'))
                    ->where('employee_id', $request->user()->employee->id)
                    ->Where(DB::raw('date(date_request)'), $row['date'])->first();

                if(count($attendance)>0){
                    foreach ($attendance as $sub_row) {
                        if($sub_row->attendance_type == 'clock in'){
                            $dates[$key]['clock_in'] = $sub_row->clock_in;
                            $dates[$key]['clock_out'] = '-';
                        }elseif($sub_row->attendance_type == 'clock out'){
                            $dates[$key]['clock_out'] = $sub_row->clock_out;
                        }else{
                            $dates[$key]['clock_in'] = '-';
                            $dates[$key]['clock_out'] = '-';
                        }
                    }
                }else{
                    $dates[$key]['clock_in'] = '-';
                    $dates[$key]['clock_out'] = '-';
                }

                $dates[$key]['shift_name'] = $shift ? $shift->shift_name : '-';;
                $dates[$key]['schedule_in'] = $shift ? $shift->working_hour_start : '-';
                $dates[$key]['schedule_out'] = $shift ? $shift->working_hour_end : '-';;
                $dates[$key]['attendance_code'] = sizeof($attendance) > 0 ? $attendance[0]->attendance_code : '-';
                $dates[$key]['time_off_code'] = $time_off ? $time_off->time_off_code : '-';
                $dates[$key]['overtime'] = $overtime ? $overtime->total_overtime : '-';

            }

            return response()->json([
                'status' => 200,
                'message' => 'Ok',
                'data' => $dates
            ]);
        }
    }

        // Function to get all the dates in given range
    private function getDatesFromRange($start, $end, $format = 'Y-m-d') {
        
        // Declare an empty array
        $array = array();
        
        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');
    
        $realEnd = new DateTime($end);
        $realEnd->add($interval);
    
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
    
        // Use loop to store date into array
        foreach($period as $date) {                 
            $array[]['date'] = $date->format($format); 
        }
    
        // Return the array elements
        return $array;
    }
}
