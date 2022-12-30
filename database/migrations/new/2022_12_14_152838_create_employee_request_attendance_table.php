<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeRequestAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_request_attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->index('employee_request_attendance_employee_id_foreign');
            $table->unsignedBigInteger('request_attendance_id')->index('employee_request_attendance_request_attendance_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_request_attendance');
    }
}
