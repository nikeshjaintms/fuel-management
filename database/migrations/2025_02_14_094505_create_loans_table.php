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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vehicle_id');
            $table->string('finance_by');
            $table->string('loan_amount');
            $table->string('loan_account');
            $table->string('emi_amount');
            $table->string('total_emi');
            $table->string('emi_paid');
            $table->string('pending_emi');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('rate_of_interest');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
