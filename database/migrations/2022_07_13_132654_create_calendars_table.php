<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('full_date');
            $table->integer('year');
            $table->integer('month');
            $table->integer('day');
            $table->integer('quarter');
            $table->integer('week');
            $table->integer('week_day');
            $table->string('day_name');
            $table->string('month_name');
            $table->char('holiday_flag', 1);
            $table->char('weekend_flag', 1);
            $table->string('event')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendars');
    }
}
