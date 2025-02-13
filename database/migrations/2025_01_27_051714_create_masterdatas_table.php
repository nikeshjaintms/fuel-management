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
        Schema::create('masterdatas', function (Blueprint $table) {
            $table->id();
            $table->string('owner_name');
            $table->bigInteger('vehicle_id');
            $table->string('type');
            $table->string('asset_make_model');
            $table->string('segment');
            $table->string('model');
            $table->string('body');
            $table->date('yom');
            $table->string('finance_by');
            $table->string('loan_amount');
            $table->string('loan_account');
            $table->string('emi_amount');
            $table->string('total_emi');
            $table->string('emi_paid');
            $table->string('pending_emi');
            $table->string('start_date');
            $table->string('end_date');
            $table->bigInteger('customer_id');
            $table->string('rate_of_interest');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masterdatas');
    }
};
