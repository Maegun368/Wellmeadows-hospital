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
{
    Schema::create('pharmaceuticals', function (Blueprint $table) {
        $table->id('drug_no');
        $table->unsignedBigInteger('supplier_no'); // FK to supplier (another module)
        $table->string('drug_name');
        $table->text('description')->nullable();
        $table->string('dosage');
        $table->string('method_of_admin');
        $table->integer('quantity_in_stock');
        $table->integer('reorder_level');
        $table->decimal('cost_per_unit', 10, 2);
        $table->timestamps();
    });
}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmaceuticals');
    }
};
