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
        Schema::create('discounts', function (Blueprint $table) {

            $table->bigIncrements( 'id' );

            $table->string( 'code' )->nullable( );

            $table->string( 'name' );

            $table->text( 'description' )->nullable( );

            $table->integer( 'uses' )->unsigned( )->nullable( );

            $table->integer( 'max_uses' )->unsigned()->nullable( );

            $table->integer( 'max_uses_user' )->unsigned( )->nullable( );

            $table->tinyInteger( 'type' )->unsigned( );

            $table->integer( 'discount_amount' );

            $table->boolean( 'is_fixed' )->default( true );

            $table->timestamp( 'starts_at' );

            $table->timestamp( 'expires_at' );

            $table->timestamps( );

            $table->softDeletes( );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
