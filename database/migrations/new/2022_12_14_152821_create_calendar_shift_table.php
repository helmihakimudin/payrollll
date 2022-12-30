<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarShiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_shift', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_id')->index('calendar_shift_shift_id_foreign');
            $table->unsignedBigInteger('calendar_id')->index('calendar_shift_calendar_id_foreign');
            $table->timestamps();
            $table->boolean('is_day_off')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendar_shift');
    }
}
