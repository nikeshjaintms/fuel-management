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
        Schema::create('maintenaces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('maintenance_date')->nullable();
            $table->text('supervisor_name')->nullable();
            $table->text('subtotal')->nullable();
            $table->text('discount')->nullable();
            $table->text('tax')->nullable();
            $table->text('tax_amount')->nullable();
            $table->decimal('total_bill_amount')->nullable();
            $table->enum('status',['pending','paid'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenaces');
    }
};
