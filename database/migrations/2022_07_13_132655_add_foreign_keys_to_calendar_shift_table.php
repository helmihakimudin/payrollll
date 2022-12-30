<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCalendarShiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendar_shift', function (Blueprint $table) {
            $table->foreign(['calendar_id'])->references(['id'])->on('calendars')->onDelete('CASCADE');
            $table->foreign(['shift_id'])->references(['id'])->on('shifts')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calendar_shift', function (Blueprint $table) {
            $table->dropForeign('calendar_shift_calendar_id_foreign');
            $table->dropForeign('calendar_shift_shift_id_foreign');
        });
    }
}
