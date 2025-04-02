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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->date('quotation_date')->nullable();
            $table->decimal('gst_charge')->nullable();
            $table->decimal('price_variation')->nullable();
            $table->decimal('present_fuel_rate')->nullable();
            $table->timestamps();
        });

        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_id')->nullable();
            $table->text('type_of_vehicle')->nullable();
            $table->decimal('km')->nullable();
            $table->decimal('rate')->nullable();
            $table->decimal('extra_km_rate')->nullable();
            $table->decimal('over_time_rate')->nullable();
            $table->decimal('average')->nullable();
            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
        Schema::dropIfExists('quotation_items');
    }
};
