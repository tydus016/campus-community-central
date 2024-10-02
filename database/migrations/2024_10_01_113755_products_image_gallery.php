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
        Schema::create('products_image_gallery', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('image_path');
            $table->integer('delete_flg')->default(NOT_DELETED)->comment('0: not deleted, 1: deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_image_gallery');
    }
};
