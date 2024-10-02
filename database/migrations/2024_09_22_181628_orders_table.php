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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->decimal('discount', 8, 2)->default(0);
            $table->decimal('tax', 8, 2)->default(0);
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->decimal('total', 8, 2)->default(0);
            $table->decimal('amount_paid', 8, 2)->default(0);
            $table->decimal('amount_change', 8, 2)->default(0);
            $table->integer('payment_method')->default(PAYMENT_METHOD_CASH);
            $table->integer('order_status')->default(ORDER_STATUS_ONGOING);
            $table->timestamps();

            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
