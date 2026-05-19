<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // null = not yet resolved, 'ward' = sent to bed assignment, 'outpatient' = sent to clinic, 'discharge' = discharged
            $table->enum('outcome', ['ward', 'outpatient', 'discharge'])->nullable()->after('examination_room');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('outcome');
        });
    }
};