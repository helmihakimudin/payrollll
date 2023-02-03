<?php

namespace App\Http\Controllers\API;

use App\EmployeeRequestOvertime;
use App\StatusRequestOvertime;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\ScheduleAssignment;
use Validator;
use DB;

class OvertimeController extends Controller
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
        
    }

    public function request(Request $request)
    {

        $rules = [
            "date_request"=>"required|date_format:Y-m-d",
            "compensation_type" => "required",
            "notes" => "required",
        ];

        if($request->overtime_before){
            $rules['overtime_before'] = "date_format:H:i";
        }

        if($request->break_before){
            $rules['break_before'] = "date_format:H:i";
        }

        if($request->overtime_after){
            $rules['overtime_after'] = "date_format:H:i";
        }

        if($request->break_after){
            $rules['break_after'] = "date_format:H:i";
        }

        if(!$request->overtime_before && !$request->overtime_after){
            return response()->json([
                'status' => 400,
                'message' => 'Please enter one of the duration'
            ]);
        }

        if($request->images){
            $rules['images'] = "array";
        }

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first().' '.$request->break_before
            ]);

        }else{

            $req_overtime = EmployeeRequestOvertime::where('date_request',$request->date_request)->where('employee_id', $request->user()->employee->id)->first();

            if(!$req_overtime){

                //insert new overtime
                $ins_overtime = new EmployeeRequestOvertime;
                $ins_overtime->employee_id       = $request->user()->employee->id;
                $ins_overtime->overtime_before   = $request->overtime_before ?? '';
                $ins_overtime->break_before      = $request->break_before ?? '';
                $ins_overtime->overtime_after    = $request->overtime_after ?? '';
                $ins_overtime->break_after       = $request->break_after ?? '';
                $ins_overtime->date_request      = $request->date_request;
                $ins_overtime->notes             = $request->notes;
                $ins_overtime->compensation_type = $request->compensation_type;
                $ins_overtime->images            = json_encode($request->images);
                $ins_overtime->save();

                //insert logs status
                $overtime_req_id = $ins_overtime->id;

                $ins_overtime_log = new StatusRequestOvertime;
                $ins_overtime_log->overtime_request_id = $overtime_req_id;
                $ins_overtime_log->status              = 'REQUEST';
                $ins_overtime_log->description         = 'Waiting for approved';
                $ins_overtime_log->save();

                //timeoff_id invalid
                return response()->json([
                    'status' => 200,
                    'message' => 'Your request has been successfully created'
                ]);
                
            }else{

                //timeoff_id invalid
                return response()->json([
                    'status' => 400,
                    'message' => 'You have already applied for overtime on the same date'
                ]);

            }

        }
        
    }

    public function list(Request $request)
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
            $data = EmployeeRequestOvertime::select('id',DB::raw("date(created_at) as date"),'compensation_type', DB::raw("(SELECT status FROM status_request_overtime WHERE overtime_request_id = employee_request_overtime.id ORDER BY created_at DESC LIMIT 1) as status"))
            ->where('employee_id', $request->user()->employee->id)
            ->where(DB::raw("date_format(created_at, '%Y-%m')"), '=', $request->month)
            ->groupBy(DB::raw("date(created_at)"))
            ->orderBy('created_at','asc')->get();

            return response()->json([
                'status' => 200,
                'message' => 'Ok',
                'data' => $data
            ]);
        }
    }

    public function detail(Request $request)
    {
        $rules = [
            "id"=>"required"
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){

            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => null
            ]);

        }else{
            $data = EmployeeRequestOvertime::select(
                'employee_request_overtime.id',DB::raw("date(employee_request_overtime.created_at) as date"),
                'compensation_type', 
                'notes', 
                DB::raw('date(date_request) as date_request'),
                DB::raw("date_format(overtime_before,'%H:%i') as overtime_before"),
                DB::raw("date_format(break_before,'%H:%i') as break_before"),
                DB::raw("date_format(overtime_after,'%H:%i') as overtime_after"),
                DB::raw("date_format(break_after,'%H:%i') as break_after"),
                'e.full_name as requested_by', 'jp.name as job_position_name'
                )
            ->leftJoin('employees as e', 'e.id', '=', 'employee_request_overtime.employee_id')
            ->leftJoin('job_position as jp', 'jp.id', '=', 'e.job_position_id')
            ->where('employee_request_overtime.employee_id', $request->user()->employee->id)
            ->where("employee_request_overtime.id", $request->id)
            ->groupBy(DB::raw("date(employee_request_overtime.created_at)"))
            ->orderBy('employee_request_overtime.created_at','asc')->first();

            if($data){

                //get last logs status
                $last_logs = DB::select('SELECT status, date(created_at) as created_at_in_date FROM status_request_overtime WHERE overtime_request_id = ? ORDER BY created_at DESC LIMIT 1',[$data->id]);
                $data->status      = $last_logs[0]->status ?? '';
                $data->approved_at = $last_logs[0]->created_at_in_date ?? '';

                //get schedule
                $schedule = ScheduleAssignment::leftJoin('shifts as s', 's.id', '=', 'schedule_assignments.shift_id')
                ->select('schedule_assignments.*', 's.name as shift_name', DB::raw("date_format(s.working_hour_start,'%H:%i') as working_hour_start"), DB::raw("date_format(s.working_hour_end,'%H:%i') as working_hour_end"))
                ->where('employee_id', $request->user()->employee->id)->where(function($query) use ($data){
                    $query->where('schedule_assignments.start_date', '<=', $data->date);
                    $query->where('schedule_assignments.end_date', '>=', $data->date);
                })->first();

                $logs_status = StatusRequestOvertime::
                select('status_request_overtime.status','status_request_overtime.created_at','e.full_name as approved_by','status_request_overtime.description')->where('overtime_request_id', $data->id)
                ->leftJoin('employees as e','e.id','=','status_request_overtime.approved_by')
                ->orderBy('created_at','desc')->get();

                $data->shift_name   = $schedule->shift_name;
                $data->schedule_in  = $schedule->working_hour_start;
                $data->schedule_out = $schedule->working_hour_end;
                $data->logs_status  = $logs_status;

                return response()->json([
                    'status' => 200,
                    'message' => 'Ok',
                    'data' => $data
                ]);

            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'Not found',
                    'data' => null
                ]);
            }
        }
    }

    public function cancelRequest(Request $request){

        $rules = [
            "overtime_id"=>"required"
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
            $logs_status = StatusRequestOvertime::where('overtime_request_id', $request->overtime_id)
                ->orderBy('created_at','desc')->first();

            if($logs_status){
                if($logs_status->status == 'REQUEST'){
                
                    //delete status CANCEL
                    StatusRequestOvertime::where('overtime_request_id', $request->overtime_id)->where('status','CANCELED')->delete();
    
                    //create canceled status
                    $ins_overtime_log = new StatusRequestOvertime;
                    $ins_overtime_log->overtime_request_id = $request->overtime_id;
                    $ins_overtime_log->status              = 'CANCELED';
                    $ins_overtime_log->description         = 'Request has been canceled';
                    $ins_overtime_log->save();

                    return response()->json([
                        'status' => 200,
                        'message' => 'Success, Your overtime request has been canceled'
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
                    'message' => 'Failed, overtime_id invalid'
                ]);
            }


        }

    }

}
