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
            $table->id();
            $table->string('vehicle_no');
            $table->string('vehicle_engine_no');
            $table->string('vehicle_chassis_no');
            $table->string('vehicle_policy_no');
            $table->date('vehicle_policy_expiry_date');
            $table->date('vehicle_fitness_expiry_date');
            $table->date('vehicle_puc_expiry_date');
            $table->timestamps();
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
