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
        Schema::create('addressables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->on('addresses')->references('id');
            $table->timestamps();
            $table->uuidMorphs('addressables');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addressables');
    }
};
