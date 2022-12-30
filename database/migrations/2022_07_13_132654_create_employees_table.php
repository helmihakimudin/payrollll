<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->unsignedBigInteger('shift_id')->nullable();
            $table->unsignedBigInteger('location_id');
            $table->string('name');
            $table->date('dob')->nullable();
            $table->string('pob', 200)->nullable();
            $table->string('gender');
            $table->string('phone')->nullable();
            $table->string('id_card', 100);
            $table->string('employee_status', 20);
            $table->string('merriage_status', 50);
            $table->string('family_card', 50);
            $table->longText('id_card_address');
            $table->string('number_children', 50);
            $table->string('address');
            $table->string('email');
            $table->string('password');
            $table->string('contract_status', 50);
            $table->string('employee_id')->default('0');
            $table->integer('branch_id');
            $table->integer('department_id');
            $table->integer('designation_id');
            $table->date('company_doj')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longText('documents')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_identifier_code')->nullable();
            $table->string('branch_location')->nullable();
            $table->string('tax_payer_id')->nullable();
            $table->integer('salary_type')->nullable();
            $table->integer('salary')->nullable();
            $table->bigInteger('calculate_work')->nullable();
            $table->bigInteger('amount_work')->nullable();
            $table->bigInteger('calculate_salary')->nullable();
            $table->bigInteger('amount_salary')->nullable();
            $table->bigInteger('net_salary')->nullable();
            $table->longText('keterangan')->nullable();
            $table->integer('is_active')->default(1);
            $table->bigInteger('amount_of_leave')->nullable();
            $table->integer('amount_paid_leave')->nullable();
            $table->string('reason', 255)->nullable();
            $table->integer('first_login_password')->default(1);
            $table->integer('created_by');


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
        Schema::dropIfExists('employees');
    }
}
