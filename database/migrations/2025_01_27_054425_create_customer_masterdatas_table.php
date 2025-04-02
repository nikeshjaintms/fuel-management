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
        Schema::create('customer_masterdatas', function (Blueprint $table) {
            $table->id();
            $table->string('customer_type')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('customer_mobile_no')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_gst')->nullable();
            $table->string('customer_pan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_masterdatas');
    }
};
