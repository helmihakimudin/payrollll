<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationInformalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education_informal', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('employee_id');
            $table->string('name', 50);
            $table->string('held_by', 50);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('duration', 10);
            $table->integer('dayshour');
            $table->date('expired_date');
            $table->string('fee', 11);
            $table->text('certificate');
            $table->integer('is_success')->nullable();
            $table->string('is_approved', 20)->nullable();
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
        Schema::dropIfExists('education_informal');
    }
}
