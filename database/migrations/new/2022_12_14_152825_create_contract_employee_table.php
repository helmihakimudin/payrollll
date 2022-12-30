<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_employee', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('employee_id')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->text('contract');
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
        Schema::dropIfExists('contract_employee');
    }
}
