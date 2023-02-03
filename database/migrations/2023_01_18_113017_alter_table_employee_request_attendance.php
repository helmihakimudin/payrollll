<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEmployeeRequestAttendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_request_attendance', function (Blueprint $table) {
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_at');
        });

        Schema::create('status_request_attendance', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_request_attendance_id');
            $table->enum('status',['REQUEST','PENDING','APPROVED','REJECTED','CANCELED']);
            $table->text('description');
            $table->integer('approved_by');
            $table->timestamp('approval_date');
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
        Schema::table('employee_request_attendance', function (Blueprint $table) {
            $table->timestamp('approved_at')->nullable();
            $table->unsignedInteger('approved_by')->index()->nullable();
        });

        Schema::dropIfExists('status_request_attendance');
    }
}
