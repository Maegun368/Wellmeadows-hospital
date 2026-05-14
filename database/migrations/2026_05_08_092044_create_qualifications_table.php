<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qualifications', function (Blueprint $table) {
            $table->id('qualification_id');
            $table->string('staff_no', 10);
            $table->string('type');
            $table->date('date_obtained');
            $table->string('institution');
            $table->timestamps();

            $table->foreign('staff_no')->references('staff_id')->on('staff');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qualifications');
    }
};