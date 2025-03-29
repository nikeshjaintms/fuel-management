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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('contract_no');
            $table->date('contract_date');
            
            $table->timestamps();
        });

        Schema::create('contract_vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->string('type');
            $table->string('min_km');
            $table->decimal('rate');
            $table->decimal('extra_km_rate');
            $table->decimal('rate_per_hour');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('contract_vehicles');
    }
};
