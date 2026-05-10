<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ← add this line

class WardSeeder extends Seeder
{
    public function run(): void
    {
        $wards = ['Ward A', 'Ward B', 'Ward C', 'ICU', 'Emergency'];

        foreach ($wards as $ward) {
            DB::table('wards')->insert([
                'ward_name'  => $ward,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}