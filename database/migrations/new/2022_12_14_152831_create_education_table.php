<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('employee_id');
            $table->string('grade', 50);
            $table->string('institute_name', 50);
            $table->string('major', 50);
            $table->string('start_year', 10);
            $table->string('end_year', 10);
            $table->string('score', 10);
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
        Schema::dropIfExists('education');
    }
}
