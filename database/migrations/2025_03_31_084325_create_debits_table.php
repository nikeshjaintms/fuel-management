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
        Schema::create('debits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('invoice_id')->nullable();
            $table->string('debit_number')->nullable();
            $table->date('debit_date')->nullable();
            $table->decimal('subtotal_amount')->nullable();
            $table->enum('tax_type',['cgst/sgst','igst'])->nullable();
            $table->decimal('tax')->nullable();
            $table->decimal('tax_amount')->nullable();
            $table->decimal('total_amount')->nullable();
            $table->timestamps();
        });

        Schema::create('debit_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('debit_id')->nullable();
            $table->string('item')->nullable();
            $table->string('hsn_sac')->nullable();
            $table->decimal('quantity')->nullable();
            $table->decimal('rate')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('amount')->nullable();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debits');
        Schema::dropIfExists('debit_items');
    }
};
