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
        Schema::create('productables', function (Blueprint $table) {
            $table->id();
            $table->uuid('product_id');
            $table->foreign('product_id')->on('products')->references('id');
            $table->timestamps();
            $table->uuidMorphs('productable');
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productables');
    }
};
