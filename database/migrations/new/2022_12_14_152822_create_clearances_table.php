<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClearancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clearances', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('employee_id', 100);
            $table->string('type_leave', 100);
            $table->text('remark')->nullable();
            $table->longText('notes')->nullable();
            $table->date('start_at');
            $table->date('end_at');
            $table->string('month', 20)->nullable();
            $table->integer('approval_check')->default(0);
            $table->integer('created_by')->nullable();
            $table->timestamps();
            $table->text('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clearances');
    }
}
