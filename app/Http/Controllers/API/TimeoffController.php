<?php

namespace App\Http\Controllers\API;

use App\TimeoffBalance;
use App\LogTimeOffBalance;
use App\Employee;
use App\StatusRequestTimeOff;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendaceResource;
use App\Http\Resources\AttendanceCollection;
use App\Http\Resources\ShiftResource;
use App\Timeoff;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\ScheduleAssignment;
use Validator;
use DB;

class TimeoffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function index(Request $request)
    {
        
    }

    public function request(Request $request)
    {

        $rules = [
            "timeoff_id"=>"required",
            "start_date" => "required|date_format:Y-m-d",
            "end_date" => "required|date_format:Y-m-d",
            "images" => "required|array",
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first()
            ]);

        }else{

            //is valid timeoff_id?
            $timeoff = Timeoff::where('id',$request->timeoff_id)->first();

            if($timeoff){

                //if time off izin, must be input request_type, schedule_in, schedule_out
                if($timeoff->code == 'I'){

                    $rules2 = [
                        "request_type"=>"required|in:FULL_DAY,HALF_DAY_BEFORE_BREAK,HALF_DAY_AFTER_BREAK"
                    ];

                    $validator2 = Validator::make($request->all(), $rules2);

                    if($validator2->fails()){

                        return response()->json([
                            'status' => 400,
                            'message' => $validator2->errors()->first()
                        ]);
            
                    }else{

                        if($request->request_type == 'HALF_DAY_BEFORE_BREAK' || $request->request_type == 'HALF_DAY_AFTER_BREAK'){

                            $rules3 = [
                                "schedule_in" => "required|date_format:H:i",
                                "schedule_out" => "required|date_format:H:i"
                            ];
        
                            $validator3 = Validator::make($request->all(), $rules3);
        
                            if($validator3->fails()){
        
                                return response()->json([
                                    'status' => 400,
                                    'message' => $validator3->errors()->first()
                                ]);
                    
                            }
                        }
                        
                    }

                }

                $quota_balance = 0;
                $balance_start = 0;
                $balance_end   = 0;

                $start_date = Carbon::parse($request->start_date);
                $end_date   = Carbon::parse($request->end_date);

                $total_req_day = $start_date->diffInDays($end_date) + 1;

                //if request type CT/Cuti Tahunan
                if($timeoff->code == 'CT'){

                    //check balance time off
                    $quota_balance = LogTimeOffBalance::where('employee_id', $request->user()->employee->id)->where('timeoff_id', $request->timeoff_id)->where('type','beginning_balance')->orderBy('created_at', 'desc')->first();
                
                    if($quota_balance){
                        if($quota_balance->status == 1){
    
                            return response()->json([
                                'status' => 200,
                                'message' => 'Your quota balance has been expired'
                            ]);
    
                        }

                        //check last balance
                        $log_timeoff_balance = LogTimeOffBalance::where('employee_id', $request->user()->employee->id)->where('timeoff_id', $request->timeoff_id)->orderBy('created_at','desc')->first();

                        $balance_start = $log_timeoff_balance ? $log_timeoff_balance->ending_balance : ($quota_balance->ending_balance ?? 0);

                        $balance_end   = $balance_start - $total_req_day;

                        if($balance_end < 0){

                            //quota balance has been exhausted
                            return response()->json([
                                'status' => 400,
                                'message' => 'Quota balance has been exhausted'
                            ]);

                        }
                    }else{
                        //quota balance not found
                        return response()->json([
                            'status' => 400,
                            'message' => 'Quota balance not found'
                        ]);
                    }
                }

                //is exist?
                $time_off_request = TimeoffBalance::select('*', DB::raw('(SELECT status FROM status_request_time_off WHERE time_off_balances_id = time_off_balances.id ORDER BY created_at DESC LIMIT 1) as status'))
                ->where('employee_id', $request->user()->employee->id)
                ->where('start_date', $request->start_date)
                ->where('end_date', $request->end_date)
                ->where('timeoff_id', $request->timeoff_id)
                ->first();

                if($time_off_request){
                    if($time_off_request->status != 'APPROVED'){
                        return response()->json([
                            'status' => 400,
                            'message' => 'You have applied before'
                        ]);
                    }
                }

                //insert request time off
                $insert = new TimeoffBalance();
                $insert->employee_id = $request->user()->employee->id;
                $insert->timeoff_id  = $request->timeoff_id;
                $insert->start_date  = $request->start_date;
                $insert->end_date    = $request->end_date;
                $insert->images      = json_encode($request->images);
                $insert->balance_start = $balance_start;
                $insert->balance_end   = $balance_end;
                $insert->delegate      = $request->delegate;

                if($request->request_type){
                    $insert->request_type = $request->request_type;
                    if($request->request_type == 'HALF_DAY_BEFORE_BREAK' || $request->request_type == 'HALF_DAY_AFTER_BREAK'){
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
                $log_timeoff_balance->start_date     = $request->start_date;
                $log_timeoff_balance->end_date       = $request->end_date;
                $log_timeoff_balance->action         = "Time off Request";
                $log_timeoff_balance->save();


                return response()->json([
                    'status' => 200,
                    'message' => 'Request has been successfully'
                ]);
                
            }else{

                //timeoff_id invalid
                return response()->json([
                    'status' => 400,
                    'message' => 'timeoff_id invalid'
                ]);

            }

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
                'data' => null
            ]);

        }else{

            $data = TimeOffBalance::leftJoin('employees', 'employees.id','=','time_off_balances.employee_id')
            ->leftJoin('job_position', 'job_position.id','=','employees.job_position_id')
            ->leftJoin('timeoffs as to', 'to.id','=','time_off_balances.timeoff_id')
            ->where('time_off_balances.employee_id', $request->user()->employee->id)
            ->where('time_off_balances.id',$request->id)
            ->select(
                'request_type',
                DB::raw("date_format(schedule_in,'%H:%i') as schedule_in_half_day"),
                DB::raw("date_format(schedule_out,'%H:%i') as schedule_out_half_day"),
                'to.code as time_off_code',
                'to.name as time_off_name',
                'to.description as time_off_dsc',
                'time_off_balances.id',
                'employees.full_name',
                'job_position.name as position_name',
                'time_off_balances.start_date',
                'time_off_balances.end_date',
                'balance_start',
                'balance_end',
                DB::raw('date(time_off_balances.created_at) as date'),
                'note',
                'images',
            )->first();

            if($data){

                //taken
                $data->taken  = $data->balance_start - $data->balance_end;

                //get last log status
                $last_log = StatusRequestTimeOff::where('time_off_balances_id', $request->id)->orderBy('created_at','desc')
                ->select(DB::raw('date(created_at) as created_at_in_date'),'status')->limit(1)->first();

                //get data schedule
                $schedule = ScheduleAssignment::leftJoin('shifts as s', 's.id', '=', 'schedule_assignments.shift_id')
                ->select('schedule_assignments.*', 's.name as shift_name', 's.working_hour_start', 's.working_hour_end', 's.show_in_request')
                ->where('employee_id', $request->user()->employee->id)->Where(function($query) use ($data){
                    $query->where('schedule_assignments.start_date', '<=', $data->date);
                    $query->where('schedule_assignments.end_date', '>=', $data->date);
                })->first();

                //test
                $logs_status = StatusRequestTimeOff::where('time_off_balances_id', $data->id)->orderBy('created_at','desc')
                ->leftJoin('employees as e','e.id','=','status_request_time_off.approved_by')
                ->leftJoin('job_position as jp', 'jp.id','=','e.job_position_id')
                ->select('status','status_request_time_off.created_at','e.full_name as approved_by','jp.name as position_name','description')->get();

                $data->shift_name   = $schedule ? $schedule->shift_name:'-';
                $data->schedule_in  = $schedule ? substr($schedule->working_hour_start,0,5):'-';
                $data->schedule_out = $schedule ? substr($schedule->working_hour_end,0,5):'-';
                $data->status       = $last_log ? $last_log->status : '-';
                $data->approved_at  = $last_log ? $last_log->created_at_in_date : '-';
                $data->logs_status  = $logs_status;
                $data->images       = json_decode($data->images??'[]');

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

    public function cancelRequest(Request $request){

        $rules = [
            "time_off_balance_id"=>"required"
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
            $logs_status = StatusRequestTimeOff::where('time_off_balances_id', $request->time_off_balance_id)
                ->orderBy('created_at','desc')->first();

            if($logs_status){
                if($logs_status->status == 'REQUEST'){
                
                    //delete status CANCEL
                    StatusRequestTimeOff::where('time_off_balances_id', $request->time_off_balance_id)->where('status','CANCELED')->delete();
    
                    //create canceled status
                    $ins_log = new StatusRequestTimeOff;
                    $ins_log->time_off_balances_id = $request->time_off_balance_id;
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

    public function balanceDetail(Request $request){

        $rules = [
            "year"=>"date_format:Y",
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => []
            ]);

        }else{

            $remaining = LogTimeOffBalance::
            select('ending_balance as remaining','value as value_taken')
            ->leftJoin('timeoffs as to', 'to.id', '=', 'log_time_off_balances.timeoff_id')
            ->where(DB::raw("date_format(log_time_off_balances.created_at, '%Y')"), '=', $request->year)
            ->where('to.code','CT')
            ->where('log_time_off_balances.employee_id', $request->user()->employee->id)
            ->orderBy('log_time_off_balances.created_at', 'desc')->first();

            $adjustment = LogTimeOffBalance::
            select('e.full_name as generate_by','start_date','log_time_off_balances.end_date','value')
            ->leftJoin('timeoffs as to', 'to.id', '=', 'log_time_off_balances.timeoff_id')
            ->leftJoin('employees as e', 'e.id', '=', 'log_time_off_balances.created_by')
            ->where(DB::raw("date_format(log_time_off_balances.created_at, '%Y')"), '=', $request->year)
            ->where('to.code','CT')
            ->where('log_time_off_balances.employee_id', $request->user()->employee->id)->where('type','adjusment')
            ->orderBy('log_time_off_balances.created_at', 'desc')->get();
            
            $beginning = LogTimeOffBalance::
            select('log_time_off_balances.start_date','value')
            ->leftJoin('timeoffs as to', 'to.id', '=', 'log_time_off_balances.timeoff_id')
            ->where(DB::raw("date_format(log_time_off_balances.created_at, '%Y')"), '=', $request->year)
            ->where('to.code','CT')
            ->where('log_time_off_balances.employee_id', $request->user()->employee->id)->where('type','beginning_balance')
            ->orderBy('log_time_off_balances.created_at', 'desc')->first();

            $time_off_taken = LogTimeOffBalance::
            select('log_time_off_balances.start_date','log_time_off_balances.end_date', 'value')
            ->leftJoin('timeoffs as to', 'to.id', '=', 'log_time_off_balances.timeoff_id')
            ->where(DB::raw("date_format(log_time_off_balances.created_at, '%Y')"), '=', $request->year)
            ->where('to.code','CT')
            ->where('log_time_off_balances.employee_id', $request->user()->employee->id)->where('type','time_off_taken')
            ->orderBy('log_time_off_balances.created_at', 'desc')->get();

            //set taken_value
            $remaining->taken_value = 0;

            //get detail taken
            foreach ($time_off_taken as $row) {
                $taken = TimeOffBalance::where('start_date', $row->start_date)->where('end_date', $row->end_date)->where('employee_id', $request->user()->employee->id)->first();
                
                $row->note = $taken->note ?? '';

                //set taken_value
                $remaining->taken_value += (int) $row->value;
            }

            $carry_forward = LogTimeOffBalance::
            select('log_time_off_balances.start_date','log_time_off_balances.end_date', 'value')
            ->leftJoin('timeoffs as to', 'to.id', '=', 'log_time_off_balances.timeoff_id')
            ->where(DB::raw("date_format(log_time_off_balances.created_at, '%Y')"), '=', $request->year)
            ->where('to.code','CT')
            ->where('log_time_off_balances.employee_id', $request->user()->employee->id)->where('type','carry_forward')
            ->orderBy('log_time_off_balances.created_at', 'desc')->get();

            $expired = LogTimeOffBalance::
            select('log_time_off_balances.end_date as expired_at','to.description as time_off_dsc', 'value')
            ->leftJoin('timeoffs as to', 'to.id', '=', 'log_time_off_balances.timeoff_id')
            ->where(DB::raw("date_format(log_time_off_balances.created_at, '%Y')"), '=', $request->year)
            ->where('to.code','CT')
            ->where('log_time_off_balances.employee_id', $request->user()->employee->id)->where('type','expired')
            ->orderBy('log_time_off_balances.created_at', 'desc')->get();
    
            $data['beginning'] = $beginning;
            $data['remaining'] = $remaining;
            $data['adjustment'] = $adjustment;
            $data['time_off_taken'] = $time_off_taken;
            $data['carry_forward'] = $carry_forward;
            $data['expired'] = $expired;
            return response()->json([
                'status' => 200,
                'message' => 'Ok',
                'data' => $data
            ]);

        }

    }

    public function type_list(){
         
        $data = Timeoff::select('id','name')->orderBy('name','asc')->get();
        return response()->json([
            'status' => 200,
            'message' => 'Ok',
            'data' => $data
        ]);

    }

    public function employeeList(Request $request){

        $rules = [
            "q"=>"max:60",
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => []
            ]);

        }else{

            $data = Employee::select('employees.id','full_name','employee_id', 'j.name as job_position_name')
            ->leftJoin('job_position as j','j.id','=','employees.job_position_id')->orderBy('name','asc')
            ->where('employees.id', '<>' , $request->user()->employee->id)
            ->where(function($query) use ($request) {
                $query->where('full_name','LIKE','%'.$request->q.'%');
                $query->orWhere('employee_id','LIKE','%'.$request->q.'%');
                $query->orWhere('j.name','LIKE','%'.$request->q.'%');
            })->get();
    
            return response()->json([
                'status' => 200,
                'message' => 'Ok',
                'data' => $data
            ]);

        }

    }

    public function requestList(Request $request)
    {
        $rules = [
            "month"=>"required|date_format:Y-m"
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => []
            ]);

        }else{
            $data = TimeoffBalance::select('time_off_balances.id',DB::raw("date(time_off_balances.created_at) as date"),'to.name as time_off_name', DB::raw("(SELECT status FROM status_request_time_off WHERE time_off_balances_id = time_off_balances.id ORDER BY created_at DESC LIMIT 1) as status"))
            ->leftJoin('timeoffs as to', 'to.id', '=', 'time_off_balances.timeoff_id')
            ->where('employee_id', $request->user()->employee->id)
            ->where(DB::raw("date_format(time_off_balances.created_at, '%Y-%m')"), '=', $request->month)
            ->groupBy(DB::raw("date(time_off_balances.created_at)"))
            ->orderBy('time_off_balances.created_at','asc')->get();

            return response()->json([
                'status' => 200,
                'message' => 'Ok',
                'data' => $data
            ]);
        }
    }
}
