<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasbonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kasbon', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('employee_id');
            $table->integer('department_id');
            $table->integer('amount');
            $table->integer('amount_accepted')->nullable();
            $table->text('remark');
            $table->text('notes')->nullable();
            $table->date('date_kasbon');
            $table->integer('approval_check')->default(0);
            $table->string('month', 20)->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('kasbon');
    }
}
