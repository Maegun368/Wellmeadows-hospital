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
       Schema::create('staff_ward', function (Blueprint $table) {
$table->id('ward_staff_id');
$table->string('ward_id');
$table->string('staff_no');
$table->string('week_start_date');
$table->text('shift');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_ward');
    }
};
