<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('contract_no')->nullable();
            $table->date('contract_date')->nullable();
            $table->date('journey_date_from')->nullable();
            $table->date('journey_date_to')->nullable();
            $table->decimal('total_km')->nullable();
            $table->decimal('total_km_amount')->nullable();
            $table->decimal('difference_rate')->nullable();
            $table->decimal('difference_amount')->nullable();
            $table->decimal('subtotal')->nullable();
            $table->decimal('cgst')->nullable();
            $table->decimal('cgst_amount')->nullable();
            $table->decimal('sgst')->nullable();
            $table->decimal('sgst_amount')->nullable();
            $table->decimal('igst')->nullable();
            $table->decimal('igst_amount')->nullable();
            $table->decimal('total_amount')->nullable();
            $table->enum('payment_status',['paid','pending'])->nullable();
            $table->timestamps();
        });

        Schema::create('invoices_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->nullable();
            // $table->unsignedBigInteger('vehicle_id');
            $table->enum('type',['A.C','Non A/C'])->nullable();
            $table->decimal('min_km')->nullable();
            $table->decimal('rate')->nullable();
            $table->decimal('amount')->nullable();
            $table->decimal('extra_km')->nullable();
            $table->decimal('extra_km_rate')->nullable();
            $table->unsignedBigInteger('extra_km_amount')->nullable();
            $table->timestamps();

        });

        Schema::create('invoices_vehicle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('invoice_item_id')->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoices_items');
        Schema::dropIfExists('invoices_vehicle');
    }
};
