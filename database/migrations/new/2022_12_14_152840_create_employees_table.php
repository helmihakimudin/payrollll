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
            $table->id();
            $table->integer('user_id')->default(0);
            $table->string('full_name')->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('req_last_name', 200)->nullable();
            $table->string('first_name', 200);
            $table->string('req_first_name', 100)->nullable();
            $table->string('email');
            $table->string('req_email', 100)->nullable();
            $table->string('mobile_phone', 20)->nullable();
            $table->string('req_mobile_phone', 20)->nullable();
            $table->string('phone')->nullable();
            $table->string('req_phone', 20)->nullable();
            $table->string('place_of_birth', 200)->nullable();
            $table->string('req_place_of_birth', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('req_date_of_birth')->nullable();
            $table->string('gender');
            $table->string('marital_status', 50);
            $table->string('req_marital_status', 50)->nullable();
            $table->string('blood_type', 10);
            $table->string('req_blood_type', 10)->nullable();
            $table->string('religion', 50);
            $table->string('req_religion', 50)->nullable();
            $table->string('identity_type', 10)->nullable();
            $table->string('req_identity_type', 10)->nullable();
            $table->string('identity_number', 100);
            $table->string('req_identity_number', 100)->nullable();
            $table->string('expired_identity', 20);
            $table->string('req_expired_identity', 20)->nullable();
            $table->string('postal_code', 20);
            $table->string('req_postal_code', 20)->nullable();
            $table->longText('citizien_id_address');
            $table->text('req_citizien_id_address')->nullable();
            $table->string('residential_address');
            $table->text('req_residential_address')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('req_employee_id', 100)->nullable();
            $table->string('barcode', 200);
            $table->string('req_barcode', 200)->nullable();
            $table->string('employee_status', 20);
            $table->date('company_doj')->nullable();
            $table->date('join_date')->nullable();
            $table->date('req_join_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('req_end_date')->nullable();
            $table->integer('branch_id');
            $table->integer('department_id');
            $table->integer('req_branch_id')->nullable();
            $table->integer('organization_id');
            $table->integer('req_organization_id')->nullable();
            $table->integer('job_position_id');
            $table->integer('req_job_position_id')->nullable();
            $table->integer('job_level_id');
            $table->integer('req_job_level_id')->nullable();
            $table->integer('schedule_id');
            $table->integer('approval_line_id');
            $table->integer('req_approval_line_id')->nullable();
            $table->string('basic_salary', 100)->default('0');
            $table->string('salary_type', 100)->nullable();
            $table->string('payment_schedule', 200);
            $table->string('preorate_setting', 200);
            $table->string('cost_center_category', 200);
            $table->string('allowance_overtime', 10);
            $table->string('bank_name')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('npwp')->nullable();
            $table->string('ptkp_status', 200)->nullable();
            $table->string('tax_method', 100)->nullable();
            $table->string('tax_salary', 20);
            $table->string('taxable_date', 100);
            $table->string('employeement_tax_status', 200);
            $table->string('netto', 100)->nullable();
            $table->string('pph21', 100)->nullable();
            $table->string('bpjs_kerja_number', 200);
            $table->string('is_bpjs_active', 100)->nullable();
            $table->date('bpjs_kerja_date')->nullable();
            $table->string('bpjs_kesehatan_number', 200);
            $table->string('bpjs_kesehatan_family', 50);
            $table->date('bpjs_kesehatan_date')->nullable();
            $table->string('bpjs_kesehatan_cost', 200);
            $table->string('bpjs_jht_cost', 30);
            $table->string('jaminan_pensiun_cost', 50);
            $table->date('jaminan_pensiun_date')->nullable();
            $table->string('password')->nullable();
            $table->string('employeement_status', 50)->nullable();
            $table->string('req_employeement_status', 50)->nullable();
            $table->integer('is_active')->default(1);
            $table->bigInteger('cash_receipt_total')->nullable();
            $table->integer('mistake_total')->nullable();
            $table->string('reason', 255)->nullable();
            $table->integer('first_login_password')->default(1);
            $table->integer('is_req_personal')->nullable();
            $table->integer('is_req_identity')->nullable();
            $table->integer('is_req_employeement')->nullable();
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
