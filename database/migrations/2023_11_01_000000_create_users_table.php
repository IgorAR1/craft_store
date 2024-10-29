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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('default_courier_address_delivery_id')->nullable();
            $table->unsignedBigInteger('default_self_delivery_address_id')->nullable();
            $table->foreign('default_courier_address_delivery_id','courier_address_user_fk')->on('addresses')->references('id');
            $table->foreign('default_self_delivery_address_id','self_address_user_fk')->on('addresses')->references('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('type')->default('guest');
            $table->boolean('is_banned')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
