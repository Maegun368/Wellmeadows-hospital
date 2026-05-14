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
        Schema::create('work_experience', function (Blueprint $table) {
            $table->id('experience_id');
            $table->string('staff_number', 10);
            $table->string('position');
            $table->string('start_date');
            $table->string('finish_date')->nullable();
            $table->string('organisation');
            $table->timestamps();
            
            $table->foreign('staff_number')->references('staff_id')->on('staff');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experience');
    }
};
