<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusRequestOvertimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_request_overtime', function (Blueprint $table) {
            $table->id();
            $table->integer('overtime_request_id');
            $table->string('status');
            $table->text('description');
            $table->integer('approved_by');
            $table->timestamp('approval_date');
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
        Schema::dropIfExists('status_request_overtime');
    }
}
