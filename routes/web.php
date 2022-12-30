<?php

use App\Http\Controllers\TimeManagementController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::group(['middleware'=>'admin'],function(){

    /*Time Off*/
    Route::get('/timeoff','Admin\TimeoffController@index')->name('timeoff');
    Route::get('/timeoff/create','Admin\TimeoffController@create')->name('timeoff.create');
    Route::get('/timeoff/assign','Admin\TimeoffController@indexAssign')->name('timeoff.assign');
    Route::get('/timeoff/assign/create','Admin\TimeoffController@createAssign')->name('timeoff.assign.create');
    Route::get('/timeoff/log','Admin\TimeoffController@logHistory')->name('timeoff.log');
    Route::get('/timeoff/setting','Admin\TimeoffController@setting')->name('timeoff.setting');

    Route::post('/timeoff/create','Admin\TimeoffController@store')->name('timeoff.store');
    Route::post('/timeoffajax','Admin\TimeoffController@timeoffajax')->name('timeoff.ajax');
    Route::get('/timeoff/edit/{id}','Admin\TimeoffController@edit')->name('timeoff.edit');
    Route::put('/timeoff/edit/{id}','Admin\TimeoffController@update')->name('timeoff.update');
    Route::post('/getEmployees', 'Admin\TimeoffController@getEmployees')->name('getEmployees');

    Route::post('/timeoff/assign/create','Admin\TimeoffController@storeAssign')->name('timeoff.assign.store');
    Route::post('/timeoffassign-ajax', 'Admin\TimeoffController@timeoffassignajax')->name('timeoff.assign.ajax');
    Route::get('/timeoff/assign/edit/{transaction_id}','Admin\TimeoffController@editAssign')->name('timeoff.assign.edit');
    Route::put('/timeoff/assign/update/{transaction_id}','Admin\TimeoffController@updateAssign')->name('timeoff.assign.update');
    Route::delete('/timeoff/assign/{transaction_id}','Admin\TimeoffController@deleteAssign')->name('timeoff.assign.delete');
    Route::put('/timeoff/setting/update','Admin\TimeoffController@settingUpdate')->name('timeoff.setting.update');
    Route::get('/timeoff/simulation/{id}','Admin\TimeoffController@simulation')->name('timeoff.simulation');
    // Route::get('/timeoff/simulation/calculate','Admin\TimeoffController@simulation')->name('timeoff.simulation.calculate');
    Route::get('/export/timeoffassign','Admin\TimeoffController@exportTimeoffassign')->name('exportTimeoffassign');



    /*Overtime*/
    Route::get('/overtime','Admin\OvertimeController@index')->name('overtime');

    /*Location*/
    Route::get('/location','Admin\LocationController@index')->name('location');
    Route::get('/location/create','Admin\LocationController@create')->name('location.create');
    Route::get('/location/edit','Admin\LocationController@edit')->name('location.edit');

    /*Attendance*/
    Route::get('/attendance','Admin\attendanceController@index')->name('attendance');
    Route::get('/attendance/create','Admin\attendanceController@create')->name('attendance.create');

    Route::post('/setting/attendance/store','Admin\attendanceController@store')->name('setting.attendance.store');
    Route::post('/setting/attendance/store-shift','Admin\attendanceController@storeShift')->name('setting.attendance.store-shift');
    Route::post('/setting/attendance/delete-shift','Admin\attendanceController@deleteShift')->name('setting.attendance.delete-shift');

    Route::post('/setting/attendance/getshift','Admin\attendanceController@getShifts')->name('setting.attendance.getshifts');
    Route::post('/setting/attendance/set-show-in-request','Admin\attendanceController@setShowInRequest')->name('setting.attendance.set-show-in-request');
    Route::post('/setting/attendance/assign-employee','Admin\attendanceController@assignEmployee')->name('setting.attendance.assign-employee');


    /*Time Management*/
    Route::get('/time-management','Admin\TimeManagementController@index')->name('time');
    Route::post('/time-management/ajax','Admin\TimeManagementController@attendAjax')->name('attend.ajax');
    Route::post('/time-management/daily-data','Admin\TimeManagementController@getDailyDataAttendance')->name('attend.daily_data');
    Route::get('/time-management/schedule','Admin\TimeManagementController@schedule')->name('time.schedule');
    Route::get('/time-management/filter-schedule-list','Admin\TimeManagementController@getFilterSchedule')->name('time.schedule.filter-list');
    Route::get('/time-management/schedule-shift-list','Admin\TimeManagementController@getShiftList')->name('time.schedule.shift-list');
    Route::post('/time-management/schedule-shift-change','Admin\TimeManagementController@changeShift')->name('time.schedule.shift-change');
    Route::post('/time-management/schedule-shift-delete','Admin\TimeManagementController@deleteShift')->name('time.schedule.shift-delete');
    Route::post('/time-management/schedule/ajax-employees','Admin\TimeManagementController@ajaxEmployees')->name('time.schedule.ajax.employee');
    Route::post('/time-management/schedule/weeks','Admin\TimeManagementController@getWeeks')->name('time.schedule.weeks');
    Route::get('/time-management/schedule/employees','Admin\TimeManagementController@getEmployee')->name('time.schedule.employees');
    Route::post('/time-management/schedule/assign-bulk','Admin\TimeManagementController@assignBulk')->name('time.schedule.assign-bulk');

    // Route::get('/time-management','Admin\TimeManagementController@index')->name('time');
    // Route::post('/time-management/ajax','Admin\TimeManagementController@attendAjax')->name('attend.ajax');
    // Route::get('/time-management/schedule','Admin\TimeManagementController@schedule')->name('time.schedule');
    // Route::post('/time-management/schedule/ajax-employees','Admin\TimeManagementController@ajaxEmployees')->name('time.schedule.ajax.employee');

    /*dashboard */
    Route::get('/', 'Admin\DashboardController@index')->name('dashboard');

    /* Pengumuman */
    Route::post('/admin/pengumuman/store','Admin\DashboardController@pengumumanstore')->name('admin.pengumuman.store');
    Route::get('/admin/pengumuman/edit/{id}','Admin\DashboardController@editpengumuman')->name('admin.pengumuman.edit');
    Route::put('/admin/pengumuman/update/{id}','Admin\DashboardController@pengumumanupdate')->name('admin.pengumuman.update');
    Route::get('/admin/pengumuman/show/{id}','Admin\DashboardController@showpengumuman')->name('admin.pengumuman.show');
    Route::get('/admin/pengumuman/destroy{id}','Admin\DashboardController@pengumumandestroy')->name('admin.pengumuman.destroy');

    /*karyawan */
    Route::get('/employee','Admin\KaryawanController@index')->name('employee');
    Route::post('/employee/ajax','Admin\KaryawanController@karyawanAjax')->name('employee.ajax');
    Route::get('/employee/create','Admin\KaryawanController@create')->name('employee.create');
    Route::post('/employee/store','Admin\KaryawanController@store')->name('employee.store');
    Route::get('/employee/export','Admin\KaryawanController@export')->name('employee.export');
    Route::get('/employee/destroy/{id}','Admin\KaryawanController@destroy')->name('employee.destroy');
    Route::post('/employee/import','Admin\KaryawanController@import')->name('employee.import');

    /*Karyawan / Aktivasi*/
    Route::get('/aktivasi','Admin\AktivasiController@index')->name('aktivasi');
    Route::get('/aktivasi/create','Admin\AktivasiController@create')->name('aktivasi.create');
    Route::get('/aktivasi/success','Admin\AktivasiController@success')->name('aktivasi.success');
    Route::get('/aktivasi/invalid','Admin\AktivasiController@invalid')->name('aktivasi.invalid');

    /*karyawan / Account / Persoanal */
    Route::get('/employee/{id}/account','Admin\KaryawanController@account')->name('employee.account');
    Route::get('employee/account/personal/{id}', 'admin\KaryawanController@account')->name('employee.account.personal');

    /* account / personal /edit & update */
    Route::get('employee/account/personal/request/edit/{id}', 'Admin\KaryawanController@personal_request_edit')->name('employee.account.personal.request.edit');
    Route::put('employee/account/personal/request/update/{id}', 'Admin\KaryawanController@personal_request_update')->name('employee.account.personal.request.update');

    /*karyawan / Account / Persoanal / family */
    Route::post('employee/account/personal/family/ajax', 'admin\KaryawanController@family_ajax')->name('employee.account.personal.family.ajax');
    Route::get('employee/account/personal/family/create/{id}', 'admin\KaryawanController@family_create')->name('employee.account.personal.family.create');
    Route::post('employee/account/personal/family/store/{id}', 'admin\KaryawanController@family_store')->name('employee.account.personal.family.store');
    Route::get('employee/account/personal/family/edit/{id}', 'admin\KaryawanController@family_edit')->name('employee.account.personal.family.edit');
    Route::PUT('employee/account/personal/family/update/{id}', 'admin\KaryawanController@family_update')->name('employee.account.personal.family.update');
    Route::get('employee/account/personal/family/show/{id}', 'admin\KaryawanController@family_show')->name('employee.account.personal.family.show');
    Route::get('employee/account/personal/family/delete/{id}', 'admin\KaryawanController@family_delete')->name('employee.account.personal.family.delete');

    /*karyawan / Account / Persoanal / emergency */
    Route::post('employee/account/personal/emergency/ajax', 'admin\KaryawanController@emergency_ajax')->name('employee.account.personal.emergency.ajax');
    Route::get('employee/account/personal/emergency/create/{id}', 'admin\KaryawanController@emergency_create')->name('employee.account.personal.emergency.create');
    Route::post('employee/account/personal/emergency/store/{id}', 'admin\KaryawanController@emergency_store')->name('employee.account.personal.emergency.store');
    Route::get('employee/account/personal/emergency/edit/{id}', 'admin\KaryawanController@emergency_edit')->name('employee.account.personal.emergency.edit');
    Route::PUT('employee/account/personal/emergency/update/{id}', 'admin\KaryawanController@emergency_update')->name('employee.account.personal.emergency.update');
    Route::get('employee/account/personal/emergency/show/{id}', 'admin\KaryawanController@emergency_show')->name('employee.account.personal.emergency.show');
    Route::get('employee/account/personal/emergency/delete/{id}', 'admin\KaryawanController@emergency_delete')->name('employee.account.personal.emergency.delete');

    /*karyawan / Account / Employement data */
    Route::get('employee/account/employeement-data/{id}', 'Admin\KaryawanController@employementdata')->name('employee.account.employeement-data');

    /*karyawan / Account / education formal*/
    Route::get('employee/account/education/{id}', 'Admin\KaryawanController@education')->name('employee.account.education');
    Route::post('employee/account/education/ajax/', 'Admin\KaryawanController@educationformalajax')->name('employee.account.education.ajax');
    Route::get('employee/account/education/create/{id}', 'Admin\KaryawanController@create_education')->name('employee.account.education.create');
    Route::post('employee/account/education/store/{id}', 'Admin\KaryawanController@store_education')->name('employee.account.education.store');
    Route::get('employee/account/education/edit/{id}', 'Admin\KaryawanController@edit_education')->name('employee.account.education.edit');
    Route::PUT('employee/account/education/update/{id}', 'Admin\KaryawanController@update_education')->name('employee.account.education.update');
    Route::get('employee/account/education/show/{id}', 'Admin\KaryawanController@show_education')->name('employee.account.education.show');
    Route::get('employee/account/education/delete/{id}', 'Admin\KaryawanController@delete_education')->name('employee.account.education.delete');

    /* karyawan / Account / education informal */
    Route::post('employee/account/education/informal/ajax/', 'Admin\KaryawanController@educationinformalajax')->name('employee.account.education.informal.ajax');
    Route::get('employee/account/education/informal/create/{id}', 'Admin\KaryawanController@create_education_informal')->name('employee.account.education.informal.create');
    Route::post('employee/account/education/informal/store/{id}', 'Admin\KaryawanController@store_informal_education')->name('employee.account.education.informal.store');
    Route::get('employee/account/education/informal/edit/{id}', 'Admin\KaryawanController@edit_education_informal')->name('employee.account.education.informal.edit');
    Route::PUT('employee/account/education/informal/update/{id}', 'Admin\KaryawanController@update_education_informal')->name('employee.account.education.informal.update');
    Route::get('employee/account/education/informal/show/{id}', 'Admin\KaryawanController@show_education_informal')->name('employee.account.education.informal.show');
    Route::get('employee/account/education/informal/delete/{id}', 'Admin\KaryawanController@delete_education_informal')->name('employee.account.education.informal.delete');

    /*karyawan / Account /  Education Working */
    Route::post('employee/account/education/working/ajax/', 'Admin\KaryawanController@educationworkingajax')->name('employee.account.education.working.ajax');
    Route::get('employee/account/education/working/create/{id}', 'Admin\KaryawanController@create_education_working')->name('employee.account.education.working.create');
    Route::post('employee/account/education/working/store/{id}', 'Admin\KaryawanController@store_education_working')->name('employee.account.education.working.store');
    Route::get('employee/account/education/working/edit/{id}', 'Admin\KaryawanController@edit_education_working')->name('employee.account.education.working.edit');
    Route::PUT('employee/account/education/working/update/{id}', 'Admin\KaryawanController@update_education_working')->name('employee.account.education.working.update');
    Route::get('employee/account/education/working/show/{id}', 'Admin\KaryawanController@show_education_working')->name('employee.account.education.working.show');
    Route::get('employee/account/education/working/delete/{id}', 'Admin\KaryawanController@delete_education_working')->name('employee.account.education.working.delete');

    /*karyawan / Account /  Payroll */
    Route::get('employee/payroll/info/{id}', 'Admin\KaryawanController@payrollinfo')->name('employee.payroll.info');
    Route::get('employee/payroll/payslip/{id}', 'Admin\KaryawanController@payslip')->name('employee.payroll.payslip');
    Route::post('employee/payroll/payslip/ajax/', 'Admin\KaryawanController@payslipAjax')->name('employee.payroll.payslip.ajax');
    Route::get('employee/payroll/payslip/detail/{id}', 'Admin\KaryawanController@payslipdetail')->name('employee.payroll.payslip.detail');
    Route::get('employee/payroll/payslip/detail/download/{id}','Admin\KaryawanController@downloadpayslippdf')->name('employee.payroll.payslip.download.pdf');
    Route::get('employee/payroll/payslip/detail/show/password/{id}','Admin\KaryawanController@showFormPassword')->name('employee.payroll.payslip.show.password');
    Route::post('employee/payroll/payslip/detail/show/passsword/store/{id}', 'Admin\KaryawanController@storepasswordpayroll')->name('employee.payroll.payslip.show.password.store');

    /*karyawan / Account / Files */
    Route::get('employee/files/{id}', 'Admin\KaryawanController@files')->name('employee.files.index');
    Route::post('employee/files/ajax', 'Admin\KaryawanController@documentsAjax')->name('employee.files.ajax');
    Route::get('employee/files/create/{id}', 'Admin\KaryawanController@createfile')->name('employee.files.create');
    Route::post('employee/files/store/{id}', 'Admin\KaryawanController@storefile')->name('employee.files.store');
    Route::get('employee/files/edit/{id}', 'Admin\KaryawanController@editfile')->name('employee.files.edit');
    Route::put('employee/files/update/{id}', 'Admin\KaryawanController@updatefile')->name('employee.files.update');
    Route::get('employee/files/show/{id}', 'Admin\KaryawanController@showfile')->name('employee.files.show');
    Route::get('employee/files/delete/{id}', 'Admin\KaryawanController@deletefile')->name('employee.files.delete');

    /*karyawan / Account / Contract */
    Route::get('employee/contract/{id}', 'Admin\KaryawanController@contract')->name('employee.contract.index');
    Route::post('employee/contract/ajax', 'Admin\KaryawanController@contractAjax')->name('employee.contract.ajax');
    Route::get('employee/contract/create/{id}', 'Admin\KaryawanController@createContract')->name('employee.contract.create');
    Route::post('employee/contract/store/{id}', 'Admin\KaryawanController@storeContract')->name('employee.contract.store');
    Route::get('employee/contract/edit/{id}', 'Admin\KaryawanController@editContract')->name('employee.contract.edit');
    Route::put('employee/contract/update/{id}', 'Admin\KaryawanController@updateContract')->name('employee.contract.update');
    Route::get('employee/contract/show/{id}', 'Admin\KaryawanController@showContract')->name('employee.contract.show');
    Route::get('employee/contract/delete/{id}', 'Admin\KaryawanController@deleteContract')->name('employee.contract.delete');


    /* payroll General */
    Route::get('/payroll','Admin\PayrollController@index')->name('payroll');

    /* payroll General | Setting tunjangan */
    Route::get('/payroll/setting','Admin\SettingController@index')->name('payroll.setting');
    Route::get('/payroll/setting/allowance/create','Admin\SettingController@createallow')->name('payroll.setting.allowance.create');
    Route::Post("/payroll/setting/allowance/store",'Admin\SettingController@storeallow')->name('payroll.setting.allowance.store');
    Route::get('/payroll/setting/allowance/edit/{id}','Admin\SettingController@editallow')->name('payroll.setting.allowance.edit');
    Route::PUT('/payroll/setting/allowance/{id}','Admin\SettingController@updateallow')->name('payroll.setting.allowance.update');
    Route::get('/payroll/setting/allowance/show/{id}','Admin\SettingController@showallow')->name('payroll.setting.allowance.show');
    Route::get('/payroll/setting/allowance/delete/{id}','Admin\SettingController@deleteallow')->name('payroll.setting.allowance.delete');


    /* payroll | Setting potongan */
    Route::get('/payroll/setting/deductions/create','Admin\SettingController@createdeductions')->name('payroll.setting.deductions.create');
    Route::Post("/payroll/setting/deductions/store",'Admin\SettingController@storedeductions')->name('payroll.setting.deductions.store');
    Route::get('/payroll/setting/deductions/edit/{id}','Admin\SettingController@editdeductions')->name('payroll.setting.deductions.edit');
    Route::PUT('/payroll/setting/deductions/{id}','Admin\SettingController@updatedeductions')->name('payroll.setting.deductions.update');
    Route::get('/payroll/setting/deductions/show/{id}','Admin\SettingController@showdeductions')->name('payroll.setting.deductions.show');
    Route::get('/payroll/setting/deductions/delete/{id}','Admin\SettingController@deletedeductions')->name('payroll.setting.deductions.delete');


    /* payroll | Setting benefit */
    Route::get('/payroll/setting/benefit/create','Admin\SettingController@createbenefit')->name('payroll.setting.benefit.create');
    Route::Post("/payroll/setting/benefit/store",'Admin\SettingController@storebenefit')->name('payroll.setting.benefit.store');
    Route::get('/payroll/setting/benefit/edit/{id}','Admin\SettingController@editbenefit')->name('payroll.setting.benefit.edit');
    Route::PUT('/payroll/setting/benefit/{id}','Admin\SettingController@updatebenefit')->name('payroll.setting.benefit.update');
    Route::get('/payroll/setting/benefit/show/{id}','Admin\SettingController@showbenefit')->name('payroll.setting.benefit.show');
    Route::get('/payroll/setting/benefit/delete/{id}','Admin\SettingController@deletebenefit')->name('payroll.setting.benefit.delete');

    /* payroll General */
    Route::get('/payroll','Admin\PayrollController@index')->name('payroll');
    Route::get('/payroll/show/run','Admin\PayrollController@showrunpayroll')->name('payroll.show.run');
    Route::get('/payroll/continue/run','Admin\PayrollController@continuepayroll')->name('payroll.continue.run');
    Route::post('/payroll/continue/run-payroll','Admin\PayrollController@runpayroll')->name('payroll.run.payroll');

     /* payroll General | Setting  */
     Route::get('/payroll/setting','Admin\PayrollController@component')->name('payroll.setting');
     Route::get('/payroll/setting/allowance/create','Admin\PayrollController@createComponentAllow')->name('payroll.setting.allowance.create');
     Route::get('/payroll/setting/deductions/create','Admin\PayrollController@createComponentDeduction')->name('payroll.setting.deduction.create');
     Route::get('/payroll/setting/benefit/create','Admin\PayrollController@createComponentBenefit')->name('payroll.setting.benefit.create');
     Route::Post("/payroll/setting/component/store",'Admin\PayrollController@storeComponent')->name('payroll.setting.component.store');
     Route::get('/payroll/setting/allowance/edit/{id}','Admin\PayrollController@editComponentAllowance')->name('payroll.setting.allowance.edit');
     Route::get('/payroll/setting/deductions/edit/{id}','Admin\PayrollController@editComponentdeductions')->name('payroll.setting.deduction.edit');
     Route::get('/payroll/setting/benefit/edit/{id}','Admin\PayrollController@editComponentBenefit')->name('payroll.setting.benefit.edit');
     Route::PUT('/payroll/setting/component/{id}','Admin\PayrollController@updateComponent')->name('payroll.setting.component.update');
     Route::get('/payroll/setting/allowance/show/{id}','Admin\PayrollController@showComponentAllow')->name('payroll.setting.allowance.show');
     Route::get('/payroll/setting/deductions/show/{id}','Admin\PayrollController@showComponentDeduction')->name('payroll.setting.deduction.show');
     Route::get('/payroll/setting/benefit/show/{id}','Admin\PayrollController@showComponentBenefit')->name('payroll.setting.benefit.show');
     Route::get('/payroll/setting/component/delete/{id}','Admin\PayrollController@deleteComponent')->name('payroll.setting.component.delete');

    /* payroll | import payroll */
    // Route::get('/payroll/component','Admin\ComponentPayrollController@index')->name('payroll.component');
    // Route::Post("/payroll/component/ajax",'Admin\ComponentPayrollController@payroll')->name('payroll.component.ajax');
    Route::get('/payroll/import','Admin\ImportPayrollController@index')->name('payroll.import');
    Route::Post("/payroll/import/ajax",'Admin\ImportPayrollController@importData')->name('payroll.import.ajax');

     /* payroll | component */
     Route::get('/payroll/component','Admin\PayrollController@componentindex')->name('payroll.component');
     Route::Post("/payroll/component/ajax",'Admin\PayrollController@componentpayroll')->name('payroll.component.ajax');
     Route::get('/payroll/component/update/form','Admin\PayrollController@upcomponent')->name('payroll.component.update.form');
     Route::get('/payroll/component/update/form/add/employee','Admin\PayrollController@add_employee')->name('payroll.compennt.update.from.add.employee');
     Route::get('/payroll/component/update/form/add/component','Admin\PayrollController@add_component')->name('payroll.compennt.update.from.add.component');
     Route::Post("/payroll/component/employee/ajax",'Admin\PayrollController@getemployeeajax')->name('payroll.component.employee.ajax');
     Route::Post("/payroll/component/component/ajax",'Admin\PayrollController@getcomponentajax')->name('payroll.component.component.ajax');
     Route::Post("/payroll/component/component/employee/store",'Admin\PayrollController@storeEmployee')->name('payroll.component.employee.store');
     Route::post('/payroll/component/component/employee/delete','Admin\PayrollController@deletedEmployee')->name('payroll.component.employee.delete');
     Route::Post("/payroll/component/component/get/filter",'Admin\PayrollController@getcomponentfilter')->name('payroll.component.get.filter');
     Route::Post("/payroll/component/component/catch/component",'Admin\PayrollController@catchcomponent')->name('payroll.component.catch.component');
     Route::get('/payroll/component/component/export','Admin\PayrollController@exportcomponent')->name('payroll.component.export');
     Route::get('/payroll/component/component/show/import','Admin\PayrollController@showimportcomponent')->name('payroll.component.show.import');
     Route::post('/payroll/component/component/import','Admin\PayrollController@importcomponent')->name('payroll.component.import');
     Route::post('/payroll/component/component/store','Admin\PayrollController@storecomponents')->name('payroll.component.store');
     Route::post('/payroll/component/update/form','Admin\PayrollController@searchEmployeeComponent')->name('payroll.component.employee.search');
     Route::get('/payroll/component/component/delete/{id}','Admin\PayrollController@deletecomponents')->name('payroll.component.delete');
     Route::get('/payroll/component/edit/{id}','Admin\PayrollController@editComponent')->name('payroll.component.edit');
     Route::get('/payroll/component/show/{id}','Admin\PayrollController@showComponent')->name('payroll.component.show');
     Route::get('/payroll/component/update/form/edit/employee/{id}','Admin\PayrollController@edit_employee')->name('payroll.component.update.form.edit.employee');
     Route::get('/payroll/component/update/form/edit/component/{id}','Admin\PayrollController@edit_component')->name('payroll.component.update.form.edit.component');
     Route::post('/payroll/component/edit/{id}','Admin\PayrollController@searchEmployeeComponentEdit')->name('payroll.component.update.form.edit.employee.search');
     Route::Post("/payroll/component/component/edit/employee/store/{id}",'Admin\PayrollController@editComponentEmployeeStore')->name('payroll.component.edit.employee.store');
     Route::Post("/payroll/component/component/edit/catch/component/{id}",'Admin\PayrollController@editCatchComponent')->name('payroll.component.edit.catch.component');
     Route::get('/payroll/component/component/edit/export/{id}','Admin\PayrollController@editexportcomponent')->name('payroll.component.edit.export');
     Route::get('/payroll/component/component/edit/show/import/{id}','Admin\PayrollController@showieditmportcomponent')->name('payroll.component.edit.show.import');
     Route::post('/payroll/component/component/edit/import/{id}','Admin\PayrollController@importeditcomponent')->name('payroll.component.edit.import');
     Route::post('/payroll/component/component/edit/update/{id}','Admin\PayrollController@reupdateComponent')->name('payroll.component.edit.update');

     /* payroll | Report */
    Route::get('/payroll/report','Admin\PayrollController@payrollreport')->name('payroll.report');
    Route::get('/payroll/report/salary/detail','Admin\PayrollController@payroll_salary_detail')->name('payroll.salary.detail');
    Route::get('/payroll/report/salary/detail/show/{id}','Admin\PayrollController@payroll_salary_detail_show')->name('payroll.salary.detail.show');
    Route::get('/payroll/report/salary/show/{id}','Admin\PayrollController@payroll_report_salary_show')->name('payroll.report.salary.show');
    Route::get('/payroll/report/salary/delete/{id}','Admin\PayrollController@payroll_report_salary_delete')->name('payroll.report.salary.delete');

    Route::get('/payroll/report/payslip/','Admin\PayrollController@payroll_report_payslip')->name('payroll.report.payslip');
    Route::get('/payroll/report/payslip/detail/{id}','Admin\PayrollController@payroll_report_payslip_detail')->name('payroll.report.payslip.detail');
    Route::get('/payroll/report/payslip/detail/pdf/{id}','Admin\PayrollController@payroll_report_payslip_detail_pdf')->name('payroll.report.payslip.detail.pdf');
    Route::get('/payroll/report/payslipbyemail/{id}','Admin\PayrollController@slipgajibyemail')->name('payroll.report.payslip.byemail');
    Route::post('/payroll/report/payslip/email/all','Admin\PayrollController@slipgajibyemailall')->name('payroll.report.payslip.email.all');
    Route::get('/payroll/report/payslip/show/{id}','Admin\PayrollController@payroll_report_payslip_show')->name('payroll.report.payslip.show');
    Route::get('/payroll/report/payslip/delete/{id}','Admin\PayrollController@payroll_report_payslip_delete')->name('payroll.report.payslip.delete');


    /* pengguna */
    Route::get('/pengguna', 'Admin\PenggunaController@index')->name('pengguna');
    Route::get('/pengguna/create', 'Admin\PenggunaController@create')->name('pengguna.buat');
    Route::post('/pengguna/store', 'Admin\PenggunaController@store')->name('pengguna.store');
    Route::post('pengguna/avatar', 'Admin\PenggunaController@avatar')->name('pengguna.avatar');
    Route::post('pengguna/signature', 'Admin\PenggunaController@signature')->name('pengguna.signature');
    Route::get('/pengguna/{id}/edit', 'Admin\PenggunaController@edit')->name('pengguna.edit');
    Route::PUT('/pengguna/{id}', 'Admin\PenggunaController@update')->name('pengguna.update');
    Route::get('/pengguna/show/{id}','Admin\PenggunaController@show')->name('pengguna.show');
    Route::get('/pengguna/{id}/destroy','Admin\PenggunaController@destroy')->name('pengguna.destroy');
    Route::get('/pengguna/{id}/active','Admin\PenggunaController@active')->name('pengguna.active');
    Route::get('/pengguna/{id}/deactive','Admin\PenggunaController@deactive')->name('pengguna.deactive');
    Route::get('/pengguna/autogenerate/{id}', 'Admin\PenggunaController@autogenerate')->name('pengguna.autogenerate');

    /* peran */
    Route::get('/peran','Admin\PeranController@index')->name('peran');
    Route::get('/peran/create','Admin\PeranController@create')->name('peran.create');
    Route::post('/peran/ajax','Admin\PeranController@peranAjax')->name('peran.ajax');
    Route::post('/peran/store','Admin\PeranController@store')->name('peran.store');
    Route::get('/peran/{id}/edit','Admin\PeranController@edit')->name('peran.edit');
    Route::PUT('/peran/{id}', 'Admin\PeranController@update')->name('peran.update');
    Route::get('/peran/show/{id}','Admin\PeranController@show')->name('peran.show');
    Route::get('/peran/{id}/destroy','Admin\PeranController@destroy')->name('peran.destroy');
    Route::post('/peran/simpan','Admin\PeranController@store')->name('peran.simpan');

    /* Permission */
    Route::get('/permission', 'Admin\PermissionController@index')->name('permission');
    Route::get('/permission/create', 'Admin\PermissionController@create')->name('permission.buat');
    Route::post('/permission/ajax', 'Admin\PermissionController@permissionAjax')->name('permission.ajax');
    Route::post('/permission/store', 'Admin\PermissionController@store')->name('permission.store');
    Route::get('/permission/{id}/edit', 'Admin\PermissionController@edit')->name('permission.edit');
    Route::PUT('/permission/{id}', 'Admin\PermissionController@update')->name('permission.update');
    Route::get('/permission/{id}/destroy', 'Admin\PermissionController@destroy')->name('permission.destroy');

    /* Approval Pay-leave */
    Route::get('/approval/pay-leave', 'Admin\ApprovalPLController@index')->name('pay-leave');
    Route::post('/approval/pay-leave/request', 'Admin\ApprovalPLController@request')->name('pay-leave.request.ajax');
    Route::post('/approval/pay-leave/accepted', 'Admin\ApprovalPLController@accepted')->name('pay-leave.accepted.ajax');
    Route::post('/approval/pay-leave/rejected', 'Admin\ApprovalPLController@rejected')->name('pay-leave.rejected.ajax');
    Route::get('/approval/pay-leave/acc/{id}', 'Admin\ApprovalPLController@acc')->name('pay-leave.acc');
    Route::get('/approval/pay-leave/dec', 'Admin\ApprovalPLController@dec')->name('pay-leave.dec');
    Route::get('/approval/pay-leave/show/{id}', 'Admin\ApprovalPLController@show')->name('pay-leave.show');

    /* Approval Clearance */
    Route::get('/approval/clearance', 'Admin\ApprovalClearanceController@index')->name('clearance');
    Route::post('/approval/clearance/request', 'Admin\ApprovalClearanceController@request')->name('clearance.request.ajax');
    Route::post('/approval/clearance/accepted', 'Admin\ApprovalClearanceController@accepted')->name('clearance.accepted.ajax');
    Route::post('/approval/clearance/rejected', 'Admin\ApprovalClearanceController@rejected')->name('clearance.rejected.ajax');
    Route::get('/approval/clearance/acc/{id}', 'Admin\ApprovalClearanceController@acc')->name('clearance.acc');
    Route::get('/approval/clearance/dec', 'Admin\ApprovalClearanceController@dec')->name('clearance.dec');
    Route::get('/approval/clearance/show/{id}', 'Admin\ApprovalClearanceController@show')->name('clearance.show');

    /* Approval Kasbon */
    Route::get('/approval/kasbon', 'Admin\ApprovalKasbonController@index')->name('kas-bon');
    Route::post('/approval/kasbon/request', 'Admin\ApprovalKasbonController@request')->name('kas-bon.request.ajax');
    Route::post('/approval/kasbon/accepted', 'Admin\ApprovalKasbonController@accepted')->name('kas-bon.accepted.ajax');
    Route::post('/approval/kasbon/rejected', 'Admin\ApprovalKasbonController@rejected')->name('kas-bon.rejected.ajax');
    Route::get('/approval/kasbon/acc/{id}', 'Admin\ApprovalKasbonController@acc')->name('kas-bon.acc');
    Route::get('/approval/kasbon/dec/', 'Admin\ApprovalKasbonController@dec')->name('kas-bon.dec');
    Route::get('/approval/kasbon/show/{id}', 'Admin\ApprovalKasbonController@show')->name('kas-bon.show');
    Route::post('/approval/kasbon/simpan', 'Admin\ApprovalKasbonController@store')->name('admin.kasbon.update');

    /*Gaji */
    Route::get('/gaji', 'Admin\GajiController@index')->name('gaji');
    Route::post('/gaji/ajax', 'Admin\GajiController@karyawanAjax')->name('gaji.ajax');
    Route::get('/gaji/buat', 'Admin\GajiController@create')->name('gaji.buat');
    Route::post('/gaji/simpan', 'Admin\GajiController@store')->name('gaji.simpan');
    Route::get('/gaji/{id}/edit', 'Admin\GajiController@edit')->name('gaji.edit');
    Route::post('/gaji/{id}/potongankasbon', 'Admin\GajiController@potonganstore')->name('gaji.kasbon.potongankasbon');
    Route::get('/gaji/export', 'Admin\GajiController@exportgaji')->name('gaji.exportgaji');
    Route::post('gaji/import', 'Admin\GajiController@importGaji')->name('gaji.import');
    Route::get('/gaji/{id}/destroy', 'Admin\GajiController@destroy')->name('gaji.destroy');

    /*slip Gaji */
    Route::get('/slipgaji','Admin\SlipGajiController@index')->name('slipgaji');
    Route::post('/slipgaji/store','Admin\SlipGajiController@store')->name('slipgaji.store');
    Route::post('/slipgaji/ajax','Admin\SlipGajiController@payslipAjax')->name('slipgaji.ajax');
    Route::get('/slipgaji/paid/{id}','Admin\SlipGajiController@paid')->name('slipgaji.paid');
    Route::post('/slipgaji/paidall','Admin\SlipGajiController@paidall')->name('slipgaji.paidalll');
    Route::post('/slipgaji/destroy','Admin\SlipGajiController@destroy')->name('slipgaji.destroy');
    Route::post('/slipgaji/export','Admin\SlipGajiController@payslipexport')->name('slipgaji.export');
    Route::get('/slipgaji/{id}/pdf','Admin\SlipGajiController@exportpdf')->name('slipgaji.pdf');
    Route::get('/slipgaji/byemail/{id}','Admin\SlipGajiController@slipgajibyemail')->name('slipgaji.byemail');
    Route::get('/slipgaji/byemail/back/{id}','Admin\SlipGajiController@slipgajibyemailback')->name('slipgaji.byemail.back');
    Route::get('/slipgaji/detail/karyawan/{id}','Admin\SlipGajiController@slipGajiDetailKaryawan')->name('slipgaji.detail.karyawan');
    Route::put('/slipgaji/detail/karyawan/update/{id}','Admin\SlipGajiController@updateSlipGajiDetailKaryawan')->name('slipgaji.detail.karyawan.update');
    Route::post('/slipgaji/annoucement/email','Admin\SlipGajiController@slipGajiAnnouncement')->name('slipgaji.annoucement.email');

    /* Cabang */
    Route::get('/branch', 'Admin\BranchController@index')->name('branch.index');
    Route::get('/branch/create', 'Admin\BranchController@create')->name('branch.create');
    Route::Post("/branch/store", 'Admin\BranchController@store')->name('branch.store');
    Route::get('/branch/{id}/edit', 'Admin\BranchController@edit')->name('branch.edit');
    Route::PUT('/branch/{id}', 'Admin\BranchController@update')->name('branch.update');
    Route::get('/branch/show/{id}','Admin\BranchController@show')->name('branch.show');
    Route::get('/branch/{id}/destory','Admin\BranchController@destroy')->name('branch.destroy');
    Route::post('/branch/get','Admin\BranchController@getBranch')->name('branch.ajax');

    /* Departement */
    Route::get('/department','Admin\DepartmentController@index')->name('department.index');
    Route::get('/department/create','Admin\DepartmentController@create')->name('department.create');
    Route::Post("/department/store",'Admin\DepartmentController@store')->name('department.store');
    Route::get('/department/{id}/edit','Admin\DepartmentController@edit')->name('department.edit');
    Route::PUT('/department/{id}', 'Admin\DepartmentController@update')->name('department.update');
    Route::get('/department/show/{id}','Admin\DepartmentController@show')->name('department.show');
    Route::get('/department/{id}/destory','Admin\DepartmentController@destroy')->name('department.destroy');
    Route::post('/department/get','Admin\DepartmentController@getDepartment')->name('department.ajax');

    /* Jabatan  */
    Route::get('/designation','Admin\DesignationController@index')->name('designation.index');
    Route::get('/designation/create','Admin\DesignationController@create')->name('designation.create');
    Route::Post("/designation/store",'Admin\DesignationController@store')->name('designation.store');
    Route::get('/designation/{id}/edit','Admin\DesignationController@edit')->name('designation.edit');
    Route::PUT('/designation/{id}','Admin\DesignationController@update')->name('designation.update');
    Route::get('/designation/show/{id}','Admin\DesignationController@show')->name('designation.show');
    Route::get('/designation/{id}/destory','Admin\DesignationController@destroy')->name('designation.destroy');
    Route::post('/designation/get','Admin\DesignationController@getDesignation')->name('designation.ajax');

    /* Jenis Slip Gaji */
    Route::get('/payslip-type','Admin\PayslipTypeController@index')->name('payslip-type.index');
    Route::get('/payslip-type/create','Admin\PayslipTypeController@create')->name('payslip-type.create');
    Route::Post("/payslip-type/store",'Admin\PayslipTypeController@store')->name('payslip-type.store');
    Route::get('/payslip-type/{id}/edit','Admin\PayslipTypeController@edit')->name('payslip-type.edit');
    Route::PUT('/payslip-type/{id}','Admin\PayslipTypeController@update')->name('payslip-type.update');
    Route::get('/payslip-type/show/{id}','Admin\PayslipTypeController@show')->name('payslip-type.show');
    Route::get('/payslip-type/{id}/destory','Admin\PayslipTypeController@destroy')->name('payslip-type.destroy');
    Route::post('/payslip-type/get','Admin\PayslipTypeController@getPayslipType')->name('payslip-type.ajax');

    /* Potongan */
    Route::get('/deduction-option','Admin\DeductionOptionController@index')->name('deduction-option.index');
    Route::get('/deduction-option/create','Admin\DeductionOptionController@create')->name('deduction-option.create');
    Route::Post("/deduction-option/store",'Admin\DeductionOptionController@store')->name('deduction-option.store');
    Route::get('/deduction-option/{id}/edit','Admin\DeductionOptionController@edit')->name('deduction-option.edit');
    Route::PUT('/deduction-option/{id}','Admin\DeductionOptionController@update')->name('deduction-option.update');
    Route::get('/deduction-option/show/{id}','Admin\DeductionOptionController@show')->name('deduction-option.show');
    Route::get('/deduction-option/{id}/destory','Admin\DeductionOptionController@destroy')->name('deduction-option.destroy');
    Route::post('/deduction-option/get','Admin\DeductionOptionController@getDeductionOption')->name('deduction-option.ajax');

    /* Kontrak */
    Route::get('/contract','Admin\ContractController@index')->name('contract.index');
    Route::get('/contract/create','Admin\ContractController@create')->name('contract.create');
    Route::Post("/contract/store",'Admin\ContractController@store')->name('contract.store');
    Route::get('/contract/{id}/edit','Admin\ContractController@edit')->name('contract.edit');
    Route::PUT('/contract/{id}','Admin\ContractController@update')->name('contract.update');
    Route::get('/contract/show{id}','Admin\ContractController@show')->name('contract.show');
    Route::get('/contract/{id}/destory','Admin\ContractController@destroy')->name('contract.destroy');
    Route::post('/contract/get','Admin\ContractController@getContract')->name('contract.ajax');

    /* Pengaturan Perusahaan */
    Route::get('/company','Admin\CompanyController@index')->name('company.index');
    Route::get('/company/{id}/ubah','Admin\CompanyController@edit')->name('company.edit');
    Route::get('/company/edit','Admin\CompanyController@setting')->name('company.setting');
    Route::PUT('/company/{id}','Admin\CompanyController@save')->name('company.save');
    Route::get('/company/{id}/destory','Admin\CompanyController@destroy')->name('company.destroy');

    /* Account */
    Route::get('/account/{id}/index','Admin\AccountController@index')->name('account.index');
    Route::Post("/contract/update",'Admin\AccountController@update')->name('account.simpan');

    /* Pengaturan currency */
    Route::get('/currency', 'Admin\CurrencyController@index')->name('currency.converter');
    Route::get('/currency/setting', 'Admin\CurrencyController@setting')->name('currency.setting');
    Route::PUT('/currency/store', 'Admin\CurrencyController@store')->name('currency.store');

    /* Account */
    Route::get('/account/{id}/index', 'Admin\AccountController@index')->name('account.index');
    Route::Post("/contract/update", 'Admin\AccountController@update')->name('account.simpan');
});

    /* karyawan */
    Route::get('/emp/login', 'karyawan\LoginController@index')->name('emp.login');
    Route::post('/emp/login', 'karyawan\LoginController@login')->name('emp.login');
    Route::group(['middleware' => 'emp'], function () {

    /*dashboard*/
    Route::get('/emp/dashboard', 'karyawan\DashboardController@index')->name('emp.dashboard');
    Route::get('/emp/dashboard/getkasbon/', 'karyawan\DashboardController@getKasbon')->name('emp.dashboard.getkasbon');
    Route::get('/emp/dashboard/getcuti', 'karyawan\DashboardController@getCuti')->name('emp.dashboard.getcuti');
    Route::post('/emp/cuti/ajax', 'karyawan\DashboardController@cutiAjax')->name('emp.dashboard.cuti.ajax');
    Route::post('/emp/kasbon/ajax', 'karyawan\DashboardController@kasbonAjax')->name('emp.emp.kasbon.ajax');
    Route::post('/emp/cuti/simpan', 'karyawan\DashboardController@simpancuti')->name('emp.dashboard.cuti.simpan');
    Route::post('/emp/kasbon/simpan', 'karyawan\DashboardController@simpankasbon')->name('emp.dashboard.kasbon.simpan');
    Route::get('/emp/dasboard/cuti/show/{id}', 'karyawan\DashboardController@show')->name('emp.dasboard.cuti.show');
    Route::get('/emp/dasboard/kasbon/show/{id}', 'karyawan\DashboardController@show2')->name('emp.dasboard.kasbon.show');
    Route::get('/emp/dasboard/izin/show/{id}', 'karyawan\DashboardController@show3')->name('emp.dasboard.izin.show');
    Route::post('/emp/dasboard/kasbon/ajax', 'karyawan\DashboardController@kasbonAjax')->name('emp.dashboard.kasbon.ajax');
    Route::post('/emp/dasboard/cuti/ajax', 'karyawan\DashboardController@cutiAjax')->name('emp.dashboard.cuti.ajax');
    Route::post('/emp/dasboard/izin/ajax', 'karyawan\DashboardController@izinAjax')->name('emp.dashboard.izin.ajax');
    Route::get('/emp/dasboard/getnewpassword', 'karyawan\DashboardController@getnewpassword')->name('emp.dashboard.getnewpassword');
    Route::post('/emp/dasboard/newpassword', 'karyawan\DashboardController@newpassword')->name('emp.dashboard.newpassword');


    /*pengumuman */
    Route::post('/emp/pengumuman/ajax', 'karyawan\DashboardController@pengumumanajax')->name('emp.pengumuman.ajax');
    Route::get('/emp/pengumuman/show/{id}', 'karyawan\DashboardController@showpengumuman')->name('emp.pengumuman.show');

    /*notification*/
    Route::get('/emp/notif/get', 'karyawan\NotificationController@getnotifkaryawan')->name('emp.notif.get');
    Route::get('/emp/notif/readat/{id}', 'karyawan\NotificationController@readatkaryawan')->name('emp.notif.readat');

    /*Account*/
    Route::get('emp/account/{id}', 'karyawan\AccountController@account')->name('emp.account');

    /*Account / Personal*/
    Route::get('emp/account/personal/{id}', 'karyawan\AccountController@account')->name('emp.account.personal');

    /* Account / Persoanal / family */
    Route::post('emp/account/personal/family/ajax', 'karyawan\AccountController@family_ajax')->name('emp.account.personal.family.ajax');
    Route::get('emp/account/personal/family/create/{id}', 'karyawan\AccountController@family_create')->name('emp.account.personal.family.create');
    Route::post('emp/account/personal/family/store/{id}', 'karyawan\AccountController@family_store')->name('emp.account.personal.family.store');
    Route::get('emp/account/personal/family/edit/{id}', 'karyawan\AccountController@family_edit')->name('emp.account.personal.family.edit');
    Route::PUT('emp/account/personal/family/update/{id}', 'karyawan\AccountController@family_update')->name('emp.account.personal.family.update');
    Route::get('emp/account/personal/family/show/{id}', 'karyawan\AccountController@family_show')->name('emp.account.personal.family.show');
    Route::get('emp/account/personal/family/delete/{id}', 'karyawan\AccountController@family_delete')->name('emp.account.personal.family.delete');

    /*Account / Persoanal / emergency */
    Route::post('emp/account/personal/emergency/ajax', 'karyawan\AccountController@emergency_ajax')->name('emp.account.personal.emergency.ajax');
    Route::get('emp/account/personal/emergency/create/{id}', 'karyawan\AccountController@emergency_create')->name('emp.account.personal.emergency.create');
    Route::post('emp/account/personal/emergency/store/{id}', 'karyawan\AccountController@emergency_store')->name('emp.account.personal.emergency.store');
    Route::get('emp/account/personal/emergency/edit/{id}', 'karyawan\AccountController@emergency_edit')->name('emp.account.personal.emergency.edit');
    Route::PUT('emp/account/personal/emergency/update/{id}', 'karyawan\AccountController@emergency_update')->name('emp.account.personal.emergency.update');
    Route::get('emp/account/personal/emergency/show/{id}', 'karyawan\AccountController@emergency_show')->name('emp.account.personal.emergency.show');
    Route::get('emp/account/personal/emergency/delete/{id}', 'karyawan\AccountController@emergency_delete')->name('emp.account.personal.emergency.delete');

    /* account / personal /edit & update */
    Route::get('emp/account/personal/request/edit/{id}', 'karyawan\AccountController@personal_request_edit')->name('emp.account.personal.request.edit');
    Route::put('emp/account/personal/request/update/{id}', 'karyawan\AccountController@personal_request_update')->name('emp.account.personal.request.update');

    /* account / personal / identity /edit & update */
    Route::put('emp/account/personal/identity/request/update/{id}', 'karyawan\AccountController@identity_request_edit')->name('emp.account.personal.identity.request.edit');
    Route::put('emp/account/personal/identity/request/update/{id}', 'karyawan\AccountController@identity_request_update')->name('emp.account.personal.identity.request.update');


    /*Account / Employement Data*/
    Route::get('emp/account/employeement-data/{id}', 'karyawan\AccountController@employementdata')->name('emp.account.employeement-data');

    /*education formal*/
    Route::get('emp/account/education/{id}', 'karyawan\AccountController@education')->name('emp.account.education');
    Route::post('emp/account/education/ajax/', 'karyawan\AccountController@educationformalajax')->name('emp.account.education.ajax');
    Route::get('emp/account/education/create/{id}', 'karyawan\AccountController@create_education')->name('emp.account.education.create');
    Route::post('emp/account/education/store/{id}', 'karyawan\AccountController@store_education')->name('emp.account.education.store');
    Route::get('emp/account/education/edit/{id}', 'karyawan\AccountController@edit_education')->name('emp.account.education.edit');
    Route::PUT('emp/account/education/update/{id}', 'karyawan\AccountController@update_education')->name('emp.account.education.update');
    Route::get('emp/account/education/show/{id}', 'karyawan\AccountController@show_education')->name('emp.account.education.show');
    Route::get('emp/account/education/delete/{id}', 'karyawan\AccountController@delete_education')->name('emp.account.education.delete');

    /* informal */
    Route::post('emp/account/education/informal/ajax/', 'karyawan\AccountController@educationinformalajax')->name('emp.account.education.informal.ajax');
    Route::get('emp/account/education/informal/create/{id}', 'karyawan\AccountController@create_education_informal')->name('emp.account.education.informal.create');
    Route::post('emp/account/education/informal/store/{id}', 'karyawan\AccountController@store_informal_education')->name('emp.account.education.informal.store');
    Route::get('emp/account/education/informal/edit/{id}', 'karyawan\AccountController@edit_education_informal')->name('emp.account.education.informal.edit');
    Route::PUT('emp/account/education/informal/update/{id}', 'karyawan\AccountController@update_education_informal')->name('emp.account.education.informal.update');
    Route::get('emp/account/education/informal/show/{id}', 'karyawan\AccountController@show_education_informal')->name('emp.account.education.informal.show');
    Route::get('emp/account/education/informal/delete/{id}', 'karyawan\AccountController@delete_education_informal')->name('emp.account.education.informal.delete');

    /* Education Working */
    Route::post('emp/account/education/working/ajax/', 'karyawan\AccountController@educationworkingajax')->name('emp.account.education.working.ajax');
    Route::get('emp/account/education/working/create/{id}', 'karyawan\AccountController@create_education_working')->name('emp.account.education.working.create');
    Route::post('emp/account/education/working/store/{id}', 'karyawan\AccountController@store_education_working')->name('emp.account.education.working.store');
    Route::get('emp/account/education/working/edit/{id}', 'karyawan\AccountController@edit_education_working')->name('emp.account.education.working.edit');
    Route::PUT('emp/account/education/working/update/{id}', 'karyawan\AccountController@update_education_working')->name('emp.account.education.working.update');
    Route::get('emp/account/education/working/show/{id}', 'karyawan\AccountController@show_education_working')->name('emp.account.education.working.show');
    Route::get('karempyawan/account/education/working/delete/{id}', 'karyawan\AccountController@delete_education_working')->name('emp.account.education.working.delete');

    /*account / Payroll */
    Route::get('emp/payroll/info/{id}', 'karyawan\GajiController@payrollinfo')->name('emp.payroll.info');
    Route::get('emp/payroll/payslip/{id}', 'karyawan\GajiController@payslip')->name('emp.payroll.payslip');
    Route::post('emp/payroll/payslip/ajax/', 'karyawan\GajiController@payslipAjax')->name('emp.payroll.payslip.ajax');
    Route::get('emp/payroll/payslip/detail/{id}', 'karyawan\GajiController@payslipdetail')->name('emp.payroll.payslip.detail');
    Route::get('emp/payroll/payslip/detail/download/{id}','karyawan\GajiController@downloadpayslippdf')->name('emp.payroll.payslip.download.pdf');
    Route::get('emp/payroll/payslip/detail/show/password/{id}','karyawan\GajiController@showFormPassword')->name('emp.payroll.payslip.show.password');
    Route::post('emp/payroll/payslip/detail/show/passsword/store/{id}', 'karyawan\GajiController@storepasswordpayroll')->name('emp.payroll.payslip.show.password.store');

    /*account /  My File */
    Route::get('emp/myfiles/{id}', 'karyawan\DocumentsController@index')->name('emp.myfile.index');
    Route::post('emp/myfiles/ajax', 'karyawan\DocumentsController@documentsAjax')->name('emp.myfile.ajax');
    Route::get('emp/myfiles/create/{id}', 'karyawan\DocumentsController@create')->name('emp.myfile.create');
    Route::post('emp/myfiles/store', 'karyawan\DocumentsController@store')->name('emp.myfile.store');
    Route::get('emp/myfiles/edit/{id}', 'karyawan\DocumentsController@edit')->name('emp.myfile.edit');
    Route::put('emp/myfiles/update/{id}', 'karyawan\DocumentsController@update')->name('emp.myfile.update');
    Route::get('emp/myfiles/show/{id}', 'karyawan\DocumentsController@show')->name('emp.myfile.show');
    Route::get('emp/myfiles/delete/{id}', 'karyawan\DocumentsController@delete')->name('emp.myfile.delete');

    /*account /  Account / Contract */
    Route::get('emp/contract/{id}', 'karyawan\DocumentsController@contract')->name('emp.contract.index');
    Route::post('emp/contract/ajax', 'karyawan\DocumentsController@contractAjax')->name('emp.contract.ajax');
    Route::get('emp/contract/create/{id}', 'karyawan\DocumentsController@createContract')->name('emp.contract.create');
    Route::post('emp/contract/store/{id}', 'karyawan\DocumentsController@storeContract')->name('emp.contract.store');
    Route::get('emp/contract/edit/{id}', 'karyawan\DocumentsController@editContract')->name('emp.contract.edit');
    Route::put('emp/contract/update/{id}', 'karyawan\DocumentsController@updateContract')->name('emp.contract.update');
    Route::get('emp/contract/show/{id}', 'karyawan\DocumentsController@showContract')->name('emp.contract.show');
    Route::get('emp/contract/delete/{id}', 'karyawan\DocumentsController@deleteContract')->name('emp.contract.delete');


    /*logout*/
    Route::get('/karyawan/logout', 'karyawan\LoginController@logout')->name('karyawan.logout');
});

// Call     alendar Procedure
Route::get('calendar-procedure', function () {
    $dateFrom = '2022-01-01';
    $dateTo = '2022-01-28';

    dump($dateFrom);
    dump($dateTo);

    $calendarProcedure = DB::select(
        'CALL fill_calendar(' . $dateFrom . ', ' . $dateTo . ')'
    );
});
