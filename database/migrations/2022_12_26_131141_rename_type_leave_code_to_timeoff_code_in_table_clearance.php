<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTypeLeaveCodeToTimeoffCodeInTableClearance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clearances', function (Blueprint $table) {
            $table->string('timeoff_code')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clearances', function (Blueprint $table) {
            $table->dropColumn('type_leave_code');
            $table->dropColumn('timeoff_code');
        });

        Schema::table('type_leaves', function (Blueprint $table) {
            $table->dropColumn('type_leave_code');
        });
    }
}
