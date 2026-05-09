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
    {Schema::create('work_experience', function (Blueprint $table) {
$table->id('experience_id');
$table->string('staff_number');
$table->string('position');
$table->string('start_date');
$table->text('finish_date');
$table->string('organizaton');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
