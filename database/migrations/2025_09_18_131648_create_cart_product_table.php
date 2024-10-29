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
        Schema::create('cart_product', function (Blueprint $table) {
            $table->id();
            $table->uuid('cart_id');
            $table->uuid('product_id');
            $table->foreign('cart_id','cart_product_cart_fk')->on('carts')->references('id');
            $table->foreign('product_id','cart_product_product_fk')->on('products')->references('id');
            $table->index('cart_id','cart_product_cart_idx');
            $table->index('product_id','cart_product_product_idx');
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_product');
    }
};
