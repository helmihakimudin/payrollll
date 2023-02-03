<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTimeOffBalances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('time_off_balances', function (Blueprint $table) {
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_at');
            $table->dropColumn('status');
        });

        Schema::create('status_request_time_off', function (Blueprint $table) {
            $table->id();
            $table->integer('time_off_balances_id');
            $table->enum('status',['REQUEST','PENDING','APPROVED','REJECTED','CANCELED']);
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
        Schema::table('time_off_balances', function (Blueprint $table) {
            $table->timestamp('approved_at')->nullable();
            $table->unsignedInteger('approved_by')->index()->nullable();
            $table->integer('status');
        });

        Schema::dropIfExists('status_request_time_off');
    }
}
