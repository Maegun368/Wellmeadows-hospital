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

            $table->integer('age');

            $table->string('gender');

            $table->string('contact_number');

            $table->string('address');

            $table->string('blood_type')->nullable();

            $table->string('ward')->nullable();

            $table->string('bed_number')->nullable();

            $table->date('admission_date')->nullable();

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