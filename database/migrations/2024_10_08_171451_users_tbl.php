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
            $table->rememberToken();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('school_id')->unique();
            $table->string('childhood_nickname');
            $table->string('bestfriend_name');
            $table->string('first_pet_name');
            $table->string('password');
            $table->smallInteger('account_type')->default(1)->comment('1 regular user, 2 admin, 3 head admin');
            $table->smallInteger('delete_flg')->default(0)->comment('0 not deleted, 1 deleted');
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
