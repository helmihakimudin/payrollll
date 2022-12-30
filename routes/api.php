<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\UserAuthController;
use API\ShiftController;
use API\AttendanceController;
use API\EmployeeController;
use App\Http\Controllers\API\AttendanceController as APIAttendanceController;
use API\LocationController as APILocationController;
use API\AnnouncementController as APIAnnoucementController;
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
    Route::get('/available-attendance', [APIAttendanceController::class, 'availableAttendance']);
    Route::get('/get-attendance-today', [APIAttendanceController::class, 'getAttendanceToday']);
    Route::get('/get-attendance-employee-pivot-id', [APIAttendanceController::class, 'getAttendanceEmployeeByPivotId']);
    Route::get('/attendance-log-month', [APIAttendanceController::class, 'getAttedanceLogMonth']);
    Route::apiResource('/', AttendanceController::class);
});
// employee
Route::apiResource('/employees', EmployeeController::class);

// locations
Route::apiResource('/locations', APILocationController::class);

//announcement
Route::apiResource('/announcements', APIAnnoucementController::class);
