<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAtTypeLeavesAndClearances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendance_employee', function (Blueprint $table) {
            $table->string('attendance_code', 8)->after('employee_id');
        });

        Schema::table('clearances', function (Blueprint $table) {
            $table->string('type_leave_code', 8)->after('type_leave');
        });

        Schema::table('type_leaves', function (Blueprint $table) {
            $table->string('type_leave_code', 8)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance_employee', function (Blueprint $table) {
            $table->dropColumn('attendance_code', 8);
        });

        Schema::table('clearances', function (Blueprint $table) {
            $table->dropColumn('type_leave_code');
        });

        Schema::table('type_leaves', function (Blueprint $table) {
            $table->dropColumn('type_leave_code');
        });
    }
}
