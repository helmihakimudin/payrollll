<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Schedule;
use App\Shift;
use App\ScheduleAssignment;
use Auth;
use Validator;
use DB;

class AttendanceController extends Controller
{
    public function index(){

        return view("admin.attendance.index");

    }

    public function create(){

        return view("admin.attendance.create");

    }

    public function store(request $request){
        
        $validator = Validator::make($request->all(),[
            "schedule_name"=>"required",
            "start_date"=>"required"
        ]);

        if($validator->fails()){

            return redirect()->back()->withInput()->withErrors($validator);

        }else{

            $employee = new Schedule;
            $employee->schedule_name = $request->schedule_name;
            $employee->is_overide_national_holiday = $request->is_overide_national_holiday;
            $employee->is_overide_company_holiday = $request->is_overide_company_holiday;
            $employee->start_date = $request->start_date;
            $employee->created_by = Auth::user()->id;
            $employee->save();
            
            return response()->json([
                'status' => 200,
                'message' => 'Schedule has been successfully created',
            ]);

        }
    }

    public function storeShift(request $request){

        if($request->id == '' || is_null($request->id)){
            //action add

            $validator = Validator::make($request->all(),[
                "name"=>"required",
                "schedule_in"=>"required",
                "schedule_out"=>"required",
                "break_start"=>"required",
                "break_end"=>"required",
            ]);
    
            if($validator->fails()){

                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first(),
                ]);

            }else{

                $is_aleready_exist_name = Shift::where('name', $request->name)->first();
                
                if($is_aleready_exist_name){

                    return response()->json([
                        'status' => 400,
                        'message' => 'Shift name '.$request->name.' already exist, Please use another shift name.',
                    ]);

                }else{

                    $shift = new Shift;
                    $shift->name = $request->name;
                    $shift->working_hour_start = $request->schedule_in;
                    $shift->working_hour_end   = $request->schedule_out;
                    $shift->break_start = $request->break_start;
                    $shift->break_end   = $request->break_end;
                    $shift->overtime_before = $request->overtime_before;
                    $shift->overtime_after  = $request->overtime_after;
                    $shift->show_in_request = $request->show_in_request;
                    $shift->clock_in_dispensation  = $request->clock_in_dispensation;
                    $shift->clock_out_dispensation = $request->clock_out_dispensation;
                    $shift->created_by = Auth::user()->id;
                    
                    $shift->save();
        
                    return response()->json([
                        'status' => 200,
                        'message' => 'Shift has been successfully created',
                    ]);

                }

            }

        }else{
            // action edit
            $validator = Validator::make($request->all(),[
                "id"=>"required",
                "name"=>"required",
                "schedule_in"=>"required",
                "schedule_out"=>"required",
                "break_start"=>"required",
                "break_end"=>"required",
            ]);
    
            if($validator->fails()){

                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()->first(),
                ]);

            }else{

                $shift = Shift::find($request->id);
                $shift->name = $request->name;
                $shift->working_hour_start = $request->schedule_in;
                $shift->working_hour_end   = $request->schedule_out;
                $shift->break_start = $request->break_start;
                $shift->break_end   = $request->break_end;
                $shift->overtime_before = $request->overtime_before;
                $shift->overtime_after  = $request->overtime_after;
                $shift->show_in_request = $request->show_in_request;
                $shift->clock_in_dispensation  = $request->clock_in_dispensation;
                $shift->clock_out_dispensation = $request->clock_out_dispensation;
                
                $shift->save();
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Shift has been successfully updated',
                ]);

            }
        }
    }

    public function getShifts(Request $request){

        $employees = Shift::select(
            '*', 
            DB::raw("concat(substr(working_hour_start, 1, 5),'-', substr(working_hour_end, 1, 5)) as working_hour, 
            concat(substr(break_start, 1, 5),'-',substr(break_end, 1, 5)) as break_hour, 
            substr(overtime_before, 1, 5) as overtime_before,
            substr(overtime_after, 1, 5) as overtime_after"),
            DB::raw("(SELECT count(*) FROM schedule_assignments sa WHERE sa.shift_id = shifts.id ) as assigned")
        )->orderBy('name', 'asc')->get();

        $json_data = array(
            "data" => $employees,
            "status" => 200,
            "message" => "Ok"
        );

        return response()->json($json_data);
    }

    public function setShowInRequest(Request $request){

        $validator = Validator::make($request->all(),[
            "shift_id"=>"required",
            "show_in_request"=>"required"
        ]);

        if($validator->fails()){

            $json_data = array(
                "status" => 400,
                "message" => $validator->errors()->first()
            );

        }else{

            $shift = Shift::find($request->shift_id);
            $shift->show_in_request = $request->show_in_request;
            $shift->save();

            $json_data = array(
                "status" => 200,
                "message" => "Data has been updated"
            );

        }
        
        return response()->json($json_data);
    }

    public function assignEmployee(Request $request){
        $validator = Validator::make($request->all(),[
            "shift_id"=>"required"
        ]);

        if($validator->fails()){

            $json_data = array(
                "status" => 400,
                "message" => $validator->errors()->first()
            );

        }else{

            $assign = ScheduleAssignment::leftJoin('employees as e', 'e.id', '=', 'schedule_assignments.employee_id')
            ->leftJoin('job_position as jp', 'jp.id', '=','e.job_position_id')
            ->where('schedule_assignments.shift_id', $request->shift_id)
            ->select('e.id','e.full_name', 'jp.name as job_position_name')
            ->get();

            $json_data = array(
                "status" => 200,
                "message" => "Ok",
                "data" => $assign
            );

        }
        
        return response()->json($json_data);
    }

    public function deleteShift(Request $request){

        $validator = Validator::make($request->all(),[
            "id"=>"required"
        ]);

        if($validator->fails()){

            $json_data = array(
                "status" => 400,
                "message" => $validator->errors()->first()
            );

        }else{

            $is_assigned = ScheduleAssignment::where('shift_id', $request->id)->get();
            if($is_assigned){
                
                $shift = Shift::find($request->id);
                $shift->delete();
        
                $json_data = array(
                    "status" => 200,
                    "message" => "Data has been successfully deleted"
                );

            }else{

                $json_data = array(
                    "status" => 400,
                    "message" => 'This shift already assigned'
                );

            }

        }

        return response()->json($json_data);
    }
}
