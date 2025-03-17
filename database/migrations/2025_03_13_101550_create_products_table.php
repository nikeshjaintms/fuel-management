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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('hsn_code')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
        });

        Schema::create('maintenance_product_used', function (Blueprint $table)
        {
            $table->id();
            $table->
            $table->bigInteger('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('rate')->nullable();
            $table->decimal('discount')->nullable();
            $table->decimal('tax')->nullable();
            $table->decimal('tax_amount')->nullable();
            $table->decimal('amount')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
