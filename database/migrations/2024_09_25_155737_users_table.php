<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('login_token')->nullable();
            $table->integer('account_type')->default(ADMIN_TYPE_SUPER)->comment('1: super admin, 2: admin, 3: staff');
            $table->integer('account_status')->default(ACCOUNT_STATUS_ACTIVE)->comment('0: inactive, 1: active');
            $table->integer('delete_flg')->default(NOT_DELETED)->comment('0: not deleted, 1: deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
