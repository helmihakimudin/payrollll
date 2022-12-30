<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergencyContactEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_contact_employee', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('employee_id');
            $table->string('name', 100);
            $table->string('relationship', 50);
            $table->string('phone_number', 20);
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
        Schema::dropIfExists('emergency_contact_employee');
    }
}
