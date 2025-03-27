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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id');
            $table->string('invoice_no');
            $table->date('invoice_date');
            $table->string('total_km');
            $table->decimal('diesel_diff_rate');
            $table->decimal('diesel_cost');
            $table->decimal('grand_subtotal');
            $table->enum('tax_type',['cgst/sgst', 'igst']);
            $table->decimal('tax');
            $table->decimal('tax_amount');
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
        });

        Schema::create('invoice_vehicle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->decimal('extra_km_drive');
            $table->decimal('km_drive');
            $table->decimal('total_extra_km_amount');
            $table->decimal('overtime');
            $table->decimal('overtime_amount');
            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoice_vehicle');
    }
};
