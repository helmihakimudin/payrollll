<?php

namespace App\Http\Controllers\API;

use App\Calendar;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShiftCollection;
use Illuminate\Http\Request;
use App\Shift;
use App\Http\Resources\ShiftResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shifts = Shift::all();

        return new ShiftCollection($shifts);
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

        $shiftWeekday = [0, 1, 2, 3, 4];
        $calendars = DB::table('calendars')
            ->whereBetween('full_date', ['2022-01-01', '2022-12-31'])
            ->whereIn('week_day', $shiftWeekday)
            ->get();
        // dd($calendars);

        // foreach ($calendars as $calendar) {
        //     dump($calendar->id);
        // }

        $shift = Shift::create([
            'name' => $request->name,
            'working_hour_start' => $request->working_hour_start,
            'working_hour_end' => $request->working_hour_end
        ]);


        foreach ($calendars as $calendar) {
            $shift->calendars()->attach($calendar->id);
        }

        return new ShiftResource($shift);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
}
