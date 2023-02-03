<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnShifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->dropColumn('schedule_id');
            $table->integer('show_in_request')->nullable()->default(0);
            $table->integer('clock_in_dispensation')->nullable();
            $table->integer('clock_out_dispensation')->nullable();
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
            $table->dropColumn('schedule_id');
            $table->dropColumn('show_in_request');
            $table->dropColumn('clock_in_dispensation');
            $table->dropColumn('clock_out_dispensation');
        });
    }
}
