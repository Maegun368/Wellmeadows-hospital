<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WardSeeder extends Seeder
{
    public function run(): void
    {
        $wards = ['Ward A', 'Ward B', 'Ward C', 'ICU', 'Emergency'];

        foreach ($wards as $i => $ward) {
            DB::table('wards')->insert([
                'ward_name'             => $ward,
                'location'              => 'Main campus',
                'total_beds'            => 20,
                'telephone_extension'   => (string) (200 + $i),
                'created_at'            => now(),
                'updated_at'            => now(),
            ]);
        }
    }
}
