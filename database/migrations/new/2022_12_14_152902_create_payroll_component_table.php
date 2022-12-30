<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollComponentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_component', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('transaksi_id', 100);
            $table->string('type_adjustment', 100);
            $table->date('effective_date');
            $table->string('end_date', 20)->nullable();
            $table->string('created_by', 100);
            $table->text('description');
            $table->string('employees', 100);
            $table->string('component', 100);
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
        Schema::dropIfExists('payroll_component');
    }
}
