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
    Schema::create('patients', function (Blueprint $table) {
        $table->id();
        $table->string('first_name');
        $table->string('last_name');
        $table->date('date_of_birth')->nullable();           // ← store DOB, compute age on the fly
        $table->string('sex')->nullable();        // ← renamed from gender
        $table->string('marital_status')->nullable();
        $table->string('phone')->nullable();      // ← renamed from contact_number
        $table->string('address')->nullable();
        $table->string('blood_type')->nullable();
        $table->string('ward')->nullable();
        $table->string('bed_number')->constrained('bed_allocation','bed_number');
        $table->date('admission_date')->nullable();
        $table->date('date_of_registration')->nullable();
        $table->string('doctor')->nullable();
        $table->string('kin_name')->nullable();
        $table->string('kin_relationship')->nullable();
        $table->string('kin_phone')->nullable();
        $table->text('medical_record')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};