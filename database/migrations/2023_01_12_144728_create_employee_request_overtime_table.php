<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeRequestOvertimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_request_overtime', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->timestamp('date_request');
            $table->enum('compensation_type',['paid_overtime','overtime_leave']);
            $table->time('overtime_before');
            $table->time('overtime_after');
            $table->time('break_before');
            $table->time('break_after');
            $table->longText('notes');
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
        Schema::dropIfExists('employee_request_overtime');
    }
}
