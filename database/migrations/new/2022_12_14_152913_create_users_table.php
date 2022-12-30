<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('branch_id')->default(0);
            $table->integer('organization_id')->default(0);
            $table->string('name');
            $table->string('gender', 10)->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->string('email')->unique('users_email_unique');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('role_id');
            $table->string('avatar')->nullable();
            $table->longText('signature')->nullable();
            $table->string('lang');
            $table->integer('is_active')->default(1);
            $table->string('created_by');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
