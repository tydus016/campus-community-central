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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->integer('sender_type')->comment('1 user, 2 admin, 3 head admin');
            $table->integer('receiver_type')->comment('1 user, 2 admin, 3 head admin');
            $table->integer('sender_id');
            $table->integer('receiver_id');
            $table->text('message_content');
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
        Schema::dropIfExists('messages');
    }
};
