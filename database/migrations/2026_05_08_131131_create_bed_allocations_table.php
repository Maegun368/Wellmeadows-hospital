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
        Schema::create('bed_allocations', function (Blueprint $table) {
        $table->id('allocation_id');
        $table->unsignedBigInteger('patient_id');
        $table->foreignId('ward_id')->constrained('wards','ward_id');
        $table->integer('bed_number');
        $table->date('date_placed_waiting')->nullable();
        $table->integer('expected_duration_days')->nullable();
        $table->date('date_placed')->nullable();
        $table->date('date_expected_leave')->nullable();
        $table->date('actual_leave_date')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bed_allocations');
    }
};
