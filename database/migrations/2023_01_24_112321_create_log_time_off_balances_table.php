<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTimeOffBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_time_off_balances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->index();
            $table->unsignedBigInteger('timeoff_id')->index();
            $table->enum('type', ['beginning_balance', 'time_off_taken', 'adjusment', 'expired', 'carry_forward']);
            $table->integer('value')->nullable();
            // check before after carry forward then expired
            $table->integer('ending_balance');
            $table->integer('status');
            // transactions, expired, carry forward, generate dll
            $table->string('action');
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
        Schema::dropIfExists('log_time_off_balances');
    }
}
