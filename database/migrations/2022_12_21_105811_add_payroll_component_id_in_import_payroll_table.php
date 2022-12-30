<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPayrollComponentIdInImportPayrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('import_payrolls', function (Blueprint $table) {
            $table->dropColumn('month');
            $table->integer('payroll_component_id')->after('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('import_payrolls', function (Blueprint $table) {
            $table->dropColumn('payroll_component_id');
        });
    }
}
