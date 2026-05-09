<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
