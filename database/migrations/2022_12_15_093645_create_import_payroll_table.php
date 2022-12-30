<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportPayrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_payrolls', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->string('month');
            $table->tinyInteger('total_attendance')->nullable();
            $table->tinyInteger('total_working_permonth')->nullable();
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
        Schema::dropIfExists('import_payrolls');
    }
}
