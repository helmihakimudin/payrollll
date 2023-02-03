<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTimeOffBalances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_off_balances', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_id')->index();
            $table->unsignedInteger('timeoff_id')->index();
            $table->date('start_date');
            $table->date('end_date');
            $table->longText('images');
            $table->unsignedInteger('approved_by')->index()->nullable();
            $table->unsignedInteger('delegate')->index()->nullable();
            $table->timestamp('apporved_at')->nullable();
            $table->integer('balance_start');
            $table->integer('balance_end');
            $table->integer('status');
            $table->text('note')->nullable();
            
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
        Schema::dropIfExists('time_off_balances');
    }
}
