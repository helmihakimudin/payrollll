<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByToLogTimeOffBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_time_off_balances', function (Blueprint $table) {
            $table->string('created_by')->after('action');
        });

        Schema::table('time_off_employees', function (Blueprint $table) {
            $table->string('created_by')->after('input_balance');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_time_off_balances', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });

        Schema::table('time_off_employees', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
    }
}
