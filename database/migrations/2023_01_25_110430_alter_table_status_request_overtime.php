<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableStatusRequestOvertime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('status_request_overtime', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('status_request_overtime', function (Blueprint $table) {
            $table->enum('status',['REQUEST','PENDING','APPROVED','REJECTED','CANCELED'])->after('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('status_request_overtime', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('status_request_overtime', function (Blueprint $table) {
            $table->string('status')->after('approved_by');
        });
    }
}
