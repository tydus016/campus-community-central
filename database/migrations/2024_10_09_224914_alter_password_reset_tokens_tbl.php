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
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->dropPrimary('email');
            $table->removeColumn('email');

            $table->id();
            $table->integer('user_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->unique();

            $table->dropColumn('id');
            $table->dropColumn('user_id');
            $table->primary('email');
        });
    }
};
