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
        Schema::create('fuel_fillings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vehicle_id');
            $table->date('filling_date');
            $table->decimal('quantity');
            $table->decimal('kilometers');
            $table->decimal('average_fuel_consumption');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_fillings');
    }
};
