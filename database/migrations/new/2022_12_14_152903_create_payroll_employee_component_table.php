<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollEmployeeComponentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_employee_component', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('employee_id');
            $table->text('component')->nullable();
            $table->integer('is_created')->default(0);
            $table->integer('is_run');
            $table->integer('is_updated')->default(0);
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
        Schema::dropIfExists('payroll_employee_component');
    }
}
