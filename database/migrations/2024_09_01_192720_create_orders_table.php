<?php

use App\Enums\OrderStatuses;
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
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->unsignedBigInteger('shipment_address_id');
            $table->string('shipment_type');
            $table->morphs('payment');
            $table->foreign('user_id','order_user_fk')->on('users')->references('id');
            $table->foreign('shipment_address_id','order_address_fk')->on('addresses')->references('id');
            $table->string('order_status')->default(OrderStatuses::AWAITING->name);
            $table->float('discounted_price');
            $table->float('total_price')->nullable();
            $table->timestamps();
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
