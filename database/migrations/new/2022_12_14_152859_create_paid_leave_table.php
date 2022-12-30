<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaidLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paid_leave', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_leave_id')->index('paid_leave_type_leave_id_foreign');
            $table->unsignedBigInteger('employee_id')->index('paid_leave_employee_id_foreign');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('no_of_days')->nullable();
            $table->text('description');
            $table->text('upload_file');
            $table->boolean('approval_check')->default(0);
            $table->unsignedBigInteger('created_by')->index('paid_leave_created_by_foreign');
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
        Schema::dropIfExists('paid_leave');
    }
}
