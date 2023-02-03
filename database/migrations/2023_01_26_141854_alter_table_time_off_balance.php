<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTimeOffBalance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('time_off_balances', function (Blueprint $table) {
            $table->enum('request_type',['FULL_DAY','HALF_DAY_BEFORE_BREAK','HALF_DAY_AFTER_BREAK'])->nullable()->after('end_date');
            $table->time('schedule_in')->nullable()->after('request_type');
            $table->time('schedule_out')->nullable()->after('schedule_in');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('time_off_balances', function (Blueprint $table) {
            $table->dropColumn('request_type');
            $table->dropColumn('schedule_in');
            $table->dropColumn('schedule_out');
        });
    }
}
