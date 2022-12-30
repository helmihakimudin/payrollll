<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_employee', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('employee_id')->default(0);
            $table->string('name', 100);
            $table->string('relationship', 50);
            $table->date('birthdate');
            $table->string('marital_status', 20);
            $table->string('gender', 50);
            $table->text('job');
            $table->string('religion', 20);
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
        Schema::dropIfExists('family_employee');
    }
}
