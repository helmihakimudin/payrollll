<?php

namespace App\Http\Controllers\API;

use App\Attendance;
use App\Calendar;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendaceResource;
use App\Http\Resources\AttendanceCollection;
use App\Http\Resources\ShiftResource;
use App\Shift;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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
        $dt = Carbon::now();
        $today = $dt->format('Y-m-d');
        $employee = $request->user()->employee;

        $isAttendanceToday = Attendance::with('employees')
            ->whereHas('employees', function (Builder $query) use ($today, $employee) {
                $query->where('employees.id', $employee->id)
                    ->where('attendances.date', $today);
            })->get();

        $test = Employee::find($employee->id)->attendances()
            ->where('date', $today)
            ->get();

        // dd($test);
        // foreach ($isAttendanceToday->employees as $value) {
        //     dump($value->pivot);
        // }




        // return $isAttendanceToday;
        // return AttendaceResource::collection($isAttendanceToday);
        return new AttendanceCollection(true, 'success', $isAttendanceToday);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dt = Carbon::now();
        $today = $dt->format('Y-m-d');
        $employee = $request->user()->employee;

        $isAttendanceToday = Attendance::with('employees')
            ->whereHas('employees', function (Builder $query) use ($today, $employee) {
                $query->where('employees.id', $employee->id)
                    ->where('attendances.date', $today);
            })->first();

        if ($isAttendanceToday) {
            dump('true');
            $isAttendanceToday->employees()->attach($employee->id, ['clock_in' => '10:00:00']);
        } else {
            dump('false');
            $attendace = Attendance::create([
                'shift_id' => $request->shift_id,
                'date' => Carbon::now()
            ]);
            $attendace->employees()->attach($employee->id, ['clock_in' => '08:00:00']);
        }




        // return new AttendaceResource($attendace);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function clockIn(Request $request)
    {
        $dt = Carbon::now();
        $today = $dt->format('Y-m-d');
        $employee = $request->user()->employee;

        $calendar = Calendar::where('full_date', $today)->first();



        $isAttendanceToday = Attendance::with('employees')
            ->whereHas('employees', function (Builder $query) use ($today, $employee) {
                $query->where('employees.id', $employee->id)
                    ->where('attendances.date', $today);
            })->first();

        if ($isAttendanceToday) {
            // dump('true');
            $isAttendanceToday->employees()->attach($employee->id, [
                'attendance_type' => 'clock in',
                'clock_in' => $request->clock_in,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'note' => $request->note,
                'image' => $request->image
            ]);
            return new AttendaceResource($isAttendanceToday);
        } else {
            // dump('false');
            $attendace = Attendance::create([
                'date' => Carbon::now(),
                'calendar_id' => $calendar->id
            ]);
            $attendace->employees()->attach($employee->id, [
                'attendance_type' => 'clock in',
                'clock_in' => $request->clock_in,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'note' => $request->note,
                'image' => $request->image
            ]);
            return new AttendaceResource($attendace);
        }
    }

    public function clockOut(Request $request)
    {
        $dt = Carbon::now();
        $today = $dt->format('Y-m-d');
        $employee = $request->user()->employee;

        $isAttendanceToday = Attendance::with('employees')
            ->whereHas('employees', function (Builder $query) use ($today, $employee) {
                $query->where('employees.id', $employee->id)
                    ->where('attendances.date', $today);
            })->first();

        // dd($isAttendanceToday->employees);
        // foreach ($isAttendanceToday->employees as $value) {
        //     dump($value->pivot->clock_in);
        // }
        // return;

        if ($isAttendanceToday) {
            dump('true');
            $isAttendanceToday->update([
                'attendance_code' => 'H'
            ]);
            $isAttendanceToday->employees()->attach($employee->id, [
                'attendance_type' => 'clock out',
                'clock_in' => $isAttendanceToday->employees[count($isAttendanceToday->employees) - 1]->pivot->clock_in,
                'clock_out' => $request->clock_out,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'note' => $request->note,
                'image' => $request->image
            ]);
            return new AttendaceResource($isAttendanceToday);
        } else {
            dump('false');
            $attendace = Attendance::create([
                'date' => Carbon::now()
            ]);
            $attendace->employees()->attach($employee->id, [
                'attendance_type' => 'clock out',
                'clock_out' => $request->clock_out,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'note' => $request->note,
                'image' => $request->image
            ]);
            return new AttendaceResource($attendace);
        }
    }

    public function availableAttendance(Request $request)
    {
        $dt = Carbon::now();
        $today = $dt->format('Y-m-d');
        $employeeId = $this->getEmployeeId($request);
        $date = $request->date;

        if (empty($date)) {
            $date = $today;
        }




        // $isAttendanceToday = Employee::with('shift')
        //     ->whereHas('shift', function (Builder $query) use ($date, $employee) {
        //         $query->where('employees.id', $employee->id)
        //             ->where('attendances.date', $date);
        //     })->first();

        $availableShift = Shift::with([
            'calendars' => function ($query) use ($date) {
                $query->where('calendars.full_date', $date);
            },

        ])
            // ->whereHas('calendars', function ($query) {
            //     $query->where('calendars.full_date', '2022-01-03');
            // })
            ->whereHas('employee', function ($query) use ($employeeId) {
                $query->where('employees.id', $employeeId);
            })->first();

        // dd($availableShift->calendars);

        $temp_data = [];
        $temp_data['calendar'] = $availableShift->calendars;

        $data = [];
        $data['data'] = $temp_data;

        return response()->json($data);



        // return new ShiftResource($test);
        // return new AttendaceResource($test);
        // return new AttendanceCollection(true, 'success', $test);
    }

    public function getAttendanceToday(Request $request)
    {

        $dt = Carbon::now();
        $today = $dt->format('Y-m-d');
        $employeeId = $this->getEmployeeId($request);

        $date = $request->date;

        if (empty($date)) {
            $date = $today;
        }

        $attendanceToday = Attendance::with('employees')
            ->whereHas('employees', function (Builder $query) use ($date, $employeeId) {
                $query->where('employees.id', $employeeId)
                    ->where('attendances.date', $date);
            })

            ->first();

        // $employee1 = Employee::find($employee->id);
        // dd($employee1->attendances()->having('pivot_id', 7)->get());

        return $attendanceToday;
    }

    public function getAttendanceEmployeeByPivotId(Request $request)
    {
        $pivotId = $request->query('id');
        $employeeId = $this->getEmployeeId($request);

        $employee = Employee::find($employeeId);

        $attendanceEmployeeByPivotId = $employee->attendances()->having('pivot_id', $pivotId)->first();

        return $attendanceEmployeeByPivotId;
    }

    public function getAttedanceLogMonth(Request $request)
    {
        $employeeId = $this->getEmployeeId($request);
        $monthIndex = 7;

        $attendaceLogs = Attendance::with('employees')
            ->whereHas('employees', function (Builder $query) use ($employeeId, $monthIndex) {
                $query->where('employees.id', $employeeId)
                    ->whereMonth('attendances.date', $monthIndex);
            })
            ->get();


        return $attendaceLogs;
    }

    private function getEmployeeId(Request $request)
    {
        return $request->user()->employee->id;
    }
}
