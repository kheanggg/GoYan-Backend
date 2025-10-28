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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->string('vehicle_id', 36)->primary();
            $table->string('vehicle_type_id', 36);
            $table->string('vehicle_name', 100);
            $table->string('shop_id', 36);
            $table->string('brand', 50)->nullable();
            $table->string('model', 50)->nullable();
            $table->year('year')->nullable();
            $table->string('color', 30)->nullable();
            $table->decimal('rental_price_per_day', 8, 2);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('vehicle_type_id')->references('vehicle_type_id')->on('vehicle_types')->onDelete('cascade');
            $table->foreign('shop_id')->references('shop_id')->on('shops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
