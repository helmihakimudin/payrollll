<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnTimeoffBalances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('time_off_balances', function (Blueprint $table) {
            $table->renameColumn('apporved_at', 'approved_at');
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
            $table->renameColumn('approved_at', 'apporved_at');
        });
    }
}
