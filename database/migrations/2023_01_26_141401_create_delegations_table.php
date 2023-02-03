<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelegationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delegate_from')->index();
            $table->unsignedBigInteger('delegate_to')->index();
            $table->date('start_date');
            $table->date('end_date');
            $table->longText('notes');
            $table->timestamps();
        });

        Schema::create('status_request_delegations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delegation_id')->index();
            $table->enum('status', ['REQUEST', 'PENDING', 'APPROVED', 'REJECTED']);
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approval_date')->index()->nullable();
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
        Schema::dropIfExists('delegations');
        Schema::dropIfExists('status_request_delegations');
    }
}
