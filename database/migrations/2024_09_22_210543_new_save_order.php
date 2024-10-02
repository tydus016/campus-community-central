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
        Schema::create('saved_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->decimal('discount', 8, 2)->default(0);
            $table->decimal('subtotal', 8, 2)->default(0);
            $table->decimal('tax', 8, 2)->default(0);
            $table->decimal('total', 8, 2)->default(0)->comment('amount payable');
            $table->timestamps();


            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
        });

        Schema::create('saved_orders_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('saved_order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('variant_id');
            $table->unsignedBigInteger('size_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('saved_order_id')->references('id')->on('saved_orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_orders');
        Schema::dropIfExists('saved_orders_items');
    }
};
