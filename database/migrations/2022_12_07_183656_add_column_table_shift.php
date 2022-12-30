<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableShift extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('working_hour_end');
            $table->date('end_date')->nullable()->after('start_date');
            $table->integer('schedule_id')->nullable()->unsigned()->after('end_date');
            $table->time('break_start')->nullable()->after('schedule_id');
            $table->time('break_end')->nullable()->after('break_start');
            $table->time('overtime_before')->nullable()->after('break_end');
            $table->time('overtime_after')->nullable()->after('overtime_before');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('schedule_id');
            $table->dropColumn('break_start');
            $table->dropColumn('break_end');
            $table->dropColumn('overtime_before');
            $table->dropColumn('overtime_after');
        });
    }
}
