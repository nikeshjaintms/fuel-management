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
        Schema::create('r_t_o_s', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vehicle_id');
            $table->date('policy_no');
            $table->date('policy_expiry_date');
            $table->date('fitness_expiry_date');
            $table->date('puc_expiry_date');
            $table->date('road_tax_expiry_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_t_o_s');
    }
};
