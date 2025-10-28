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
        Schema::create('shops', function (Blueprint $table) {
            $table->string('shop_id', 36)->primary();
            $table->string('shop_name', 100);
            $table->string('location_id', 36);
            $table->string('address', 255);
            $table->string('phone_number', 15);
            $table->string('email', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('shop_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
