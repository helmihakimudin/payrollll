<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_transfer', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('employee_id');
            $table->integer('branch_id')->nullable();
            $table->integer('organization_id');
            $table->integer('job_position_id');
            $table->integer('job_level_id');
            $table->date('effective_date');
            $table->string('employeement_status', 100);
            $table->text('transfer_reason');
            $table->integer('is_success')->nullable();
            $table->integer('is_approved')->nullable();
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
        Schema::dropIfExists('employee_transfer');
    }
}
