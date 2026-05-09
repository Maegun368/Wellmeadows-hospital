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
       Schema::create('qualifications', function (Blueprint $table) {
$table->id('qualification_id');
$table->foreignId('staff_no')->constrained('staff','staff_id');
$table->string('type');
$table->date('date_obtained');
$table->string('institution');
$table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qualifications');
    }
};
