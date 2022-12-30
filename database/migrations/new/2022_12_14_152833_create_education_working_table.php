<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationWorkingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education_working', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('employee_id');
            $table->string('company', 200);
            $table->string('position', 200);
            $table->date('froms');
            $table->date('tos');
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
        Schema::dropIfExists('education_working');
    }
}
