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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('target_user_type')->comment('1 regular, 2 admin, 3 head admin, 4 general');
            $table->integer('target_id')->comment('user_id, organization_id');
            $table->string('notif_title');
            $table->string('notif_body');
            $table->smallInteger('read_flg')->comment('0 unread, 1 read');
            $table->smallInteger('delete_flg')->default(0)->comment('0 not deleted, 1 deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
