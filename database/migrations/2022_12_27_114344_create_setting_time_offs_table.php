<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTimeOffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_time_offs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('timeoff_id');
            $table->integer('duration')->nullable();
            $table->string('include_day_off')->nullable();
            $table->string('allow_half_day')->nullable();
            $table->string('set_schedule_half_day')->nullable();
            $table->string('set_default')->nullable();
            $table->string('emerge_at_join')->nullable();
            $table->string('show')->nullable();
            $table->integer('max_request')->nullable();
            $table->string('allow_minus')->nullable();
            $table->integer('minus_amount')->nullable();
            $table->string('carry_forward')->nullable();
            $table->integer('carry_amount')->nullable();
            $table->integer('carry_expired')->nullable();
            $table->string('time_off_compensation')->nullable();
            $table->string('attachment_mandatory')->nullable();

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
        Schema::dropIfExists('setting_time_offs');
    }
}
