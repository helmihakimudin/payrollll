<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_employee', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attendance_id')->index('attendance_employee_attendance_id_foreign');
            $table->unsignedBigInteger('employee_id')->index('attendance_employee_employee_id_foreign');
            $table->string('attendance_type');
            $table->time('clock_in')->nullable();
            $table->time('clock_out')->nullable();
            $table->decimal('latitude', 8, 6)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();
            $table->text('note')->nullable();
            $table->text('image')->nullable();
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
        Schema::dropIfExists('attendance_employee');
    }
}
