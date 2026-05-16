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
        Schema::create('staff', function (Blueprint $table) {
$table->string('staff_id', 10)->primary();
$table->string('first_name');
$table->string('last_name');
$table->string('position');
$table->text('address');
$table->string('phone');
$table->date('date_of_birth');
$table->enum('sex', ['Male','Female','Other']);
$table->decimal('current_salary', 10, 2);
$table->integer('hours_per_week');
$table->enum('contract_type', ['Full-time','Part-time']);
$table->enum('pay_type', ['Monthly','Weekly']);
$table->string('NIN')->unique();
$table->string('salary_scale');
$table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
