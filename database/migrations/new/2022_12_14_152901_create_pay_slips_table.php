<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaySlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_slips', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->integer('net_payble')->nullable();
            $table->string('salary_month')->nullable();
            $table->integer('status')->nullable();
            $table->integer('is_bpjs_active')->default(0);
            $table->integer('basic_salary')->nullable();
            $table->text('allowance')->nullable();
            $table->text('deduction')->nullable();
            $table->integer('slipbyemail')->default(0);
            $table->string('created_by', 200)->nullable();
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
        Schema::dropIfExists('pay_slips');
    }
}
