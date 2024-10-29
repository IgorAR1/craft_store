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
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->uuid('order_id');
            $table->uuid('product_id');
            $table->foreign('order_id','order_product_cart_fk')->on('orders')->references('id');
            $table->foreign('product_id','order_product_product_fk')->on('products')->references('id');
            $table->index('order_id','order_product_cart_idx');
            $table->index('product_id','order_product_product_idx');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
