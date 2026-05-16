<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // null = not yet resolved, 'out_patient' = sent to clinic, 'admitted' = placed on ward waiting list
            $table->string('outcome')->nullable()->after('examination_room');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('outcome');
        });
    }
};