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
        Schema::create('patient_medications', function (Blueprint $table) {
    $table->id('medication_id');
    $table->unsignedBigInteger('patient_id');
    $table->foreignId('drug_no')->constrained('pharmaceuticals', 'drug_no');
    $table->string('method_of_admin');
    $table->integer('units_per_day');
    $table->date('start_date');
    $table->date('finish_date');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_medications');
    }
};
