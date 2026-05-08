<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('appointments', function (Blueprint $table) {
        $table->id('appointment_id');
        $table->unsignedBigInteger('patient_id');
        $table->unsignedBigInteger('consultant_id');
        $table->date('appointment_date');
        $table->time('appointment_time');
        $table->string('examination_room');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('appointments');
}
};
