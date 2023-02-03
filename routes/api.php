<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\UserAuthController;
use API\ShiftController;
use API\AttendanceController;
use API\EmployeeController;
use App\Http\Controllers\API\AttendanceController as APIAttendanceController;
use App\Http\Controllers\API\TimeoffController as APITimeoffController;
use API\LocationController as APILocationController;
use API\AnnouncementController as APIAnnoucementController;
use App\Http\Controllers\API\OvertimeController;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user()->employee;
// });

Route::get('/user', [UserController::class, 'index'])->middleware('auth:api');

Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/login', [UserAuthController::class, 'login']);

// shift
Route::apiResource('/shifts', ShiftController::class);

// attendance
Route::prefix('attendances')->group(function () {
    Route::post('/clock-in', [APIAttendanceController::class, 'clockIn']);
    Route::post('/clock-out', [APIAttendanceController::class, 'clockOut']);
    // Route::get('/available-attendance', [APIAttendanceController::class, 'availableAttendance']);
    Route::get('/schedule-by-date', [APIAttendanceController::class, 'getScheduleByDate']);
    // Route::get('/get-attendance-employee-pivot-id', [APIAttendanceController::class, 'getAttendanceEmployeeByPivotId']);
    Route::get('/attendance-history-by-month', [APIAttendanceController::class, 'getAttendanceHistoryByMonth']);
    Route::get('/attendance-history', [APIAttendanceController::class, 'getAttendanceHistory']);
    Route::post('/request', [APIAttendanceController::class, 'request']);
    Route::post('/cancel-request', [APIAttendanceController::class, 'cancelRequest']);
    Route::get('/request-list', [APIAttendanceController::class, 'requestList']);
    Route::get('/request-detail', [APIAttendanceController::class, 'requestDetail']);
    // Route::apiResource('/', AttendanceController::class);
    Route::post('/logs', [APIAttendanceController::class, 'logs']);
});

Route::prefix('time_off')->group(function () {
    Route::post('/request', [APITimeoffController::class, 'request']);
    Route::get('/request-detail', [APITimeoffController::class, 'requestDetail']);
    Route::post('/cancel-request', [APITimeoffController::class, 'cancelRequest']);
    Route::get('/type_list', [APITimeoffController::class, 'type_list']);
    Route::get('/employee_list', [APITimeoffController::class, 'employeeList']);
    Route::get('/request-list', [APITimeoffController::class, 'requestList']);
    Route::post('/balance-detail', [APITimeoffController::class, 'balanceDetail']);
});

Route::prefix('overtime')->group(function () {
    Route::post('/request', [OvertimeController::class, 'request']);
    Route::post('/cancel-request', [OvertimeController::class, 'cancelRequest']);
    Route::post('/list', [OvertimeController::class, 'list']);
    Route::post('/detail', [OvertimeController::class, 'detail']);
});

// employee
Route::apiResource('/employees', EmployeeController::class);

// locations
Route::apiResource('/locations', APILocationController::class);

//announcement
Route::apiResource('/announcements', APIAnnoucementController::class);
