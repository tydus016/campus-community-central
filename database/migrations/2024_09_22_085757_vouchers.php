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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_code');
            $table->integer('discount');
            $table->integer('type')->default(1)->comment('1 General, 2 Product, 3 Category');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->boolean('delete_flg')->default(NOT_DELETED);
            $table->integer('availability_flg')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
