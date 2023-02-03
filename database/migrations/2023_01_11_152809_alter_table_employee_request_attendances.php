<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEmployeeRequestAttendances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('employee_request_attendance', function (Blueprint $table) {
            $table->time('clock_in');
            $table->time('clock_out');
            $table->date('date');
            $table->text('note')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedInteger('approved_by')->index()->nullable();
            $table->dropColumn('request_attendance_id');
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
            $table->dropColumn('clock_in');
            $table->dropColumn('clock_out');
            $table->dropColumn('date');
            $table->dropColumn('note');
            $table->dropColumn('approved_at');
            $table->dropColumn('approved_by');
            $table->unsignedInteger('request_attendance_id');
        });

    }
}
