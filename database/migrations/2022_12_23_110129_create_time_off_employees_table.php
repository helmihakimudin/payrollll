<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeOffEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_off_employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('timeoff_id')->index();
            $table->string('type');
            $table->longText('description');
            $table->unsignedBigInteger('employee_id')->index();
            $table->integer('input_balance');
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('time_off_employees');
    }
}
