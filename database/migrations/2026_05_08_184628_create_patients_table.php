<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * ERD PATIENT: patient_id, names, DOB, sex, marital_status, address, phone, date_registered.
     * doctor_id is added after doctors table exists (see align_database_with_erd migration).
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth')->nullable();
            $table->string('sex');
            $table->string('marital_status')->nullable();
            $table->string('phone');
            $table->string('address');
            $table->date('date_registered')->nullable();
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
