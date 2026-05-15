<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WardSeeder extends Seeder
{
    public function run(): void
    {
        $wards = [
            [
                'ward_name'           => 'Orthopedic',
                'location'            => 'E Block',
                'total_beds'          => 16,
                'telephone_extension' => 'Extn. 7711',
            ],
            [
                'ward_name'           => 'Cardiology',
                'location'            => 'A Block',
                'total_beds'          => 14,
                'telephone_extension' => 'Extn. 7712',
            ],
            [
                'ward_name'           => 'Neurology',
                'location'            => 'B Block',
                'total_beds'          => 14,
                'telephone_extension' => 'Extn. 7713',
            ],
            [
                'ward_name'           => 'Pediatrics',
                'location'            => 'C Block',
                'total_beds'          => 16,
                'telephone_extension' => 'Extn. 7714',
            ],
            [
                'ward_name'           => 'Maternity',
                'location'            => 'D Block',
                'total_beds'          => 14,
                'telephone_extension' => 'Extn. 7715',
            ],
            [
                'ward_name'           => 'General Surgery',
                'location'            => 'A Block',
                'total_beds'          => 16,
                'telephone_extension' => 'Extn. 7716',
            ],
            [
                'ward_name'           => 'Oncology',
                'location'            => 'F Block',
                'total_beds'          => 12,
                'telephone_extension' => 'Extn. 7717',
            ],
            [
                'ward_name'           => 'Geriatrics',
                'location'            => 'G Block',
                'total_beds'          => 16,
                'telephone_extension' => 'Extn. 7718',
            ],
            [
                'ward_name'           => 'Respiratory',
                'location'            => 'B Block',
                'total_beds'          => 14,
                'telephone_extension' => 'Extn. 7719',
            ],
            [
                'ward_name'           => 'Urology',
                'location'            => 'C Block',
                'total_beds'          => 12,
                'telephone_extension' => 'Extn. 7720',
            ],
            [
                'ward_name'           => 'Ophthalmology',
                'location'            => 'E Block',
                'total_beds'          => 10,
                'telephone_extension' => 'Extn. 7721',
            ],
            [
                'ward_name'           => 'Dermatology',
                'location'            => 'F Block',
                'total_beds'          => 10,
                'telephone_extension' => 'Extn. 7722',
            ],
            [
                'ward_name'           => 'Psychiatry',
                'location'            => 'H Block',
                'total_beds'          => 16,
                'telephone_extension' => 'Extn. 7723',
            ],
            [
                'ward_name'           => 'Endocrinology',
                'location'            => 'D Block',
                'total_beds'          => 12,
                'telephone_extension' => 'Extn. 7724',
            ],
            [
                'ward_name'           => 'Gastroenterology',
                'location'            => 'G Block',
                'total_beds'          => 14,
                'telephone_extension' => 'Extn. 7725',
            ],
            [
                'ward_name'           => 'Nephrology',
                'location'            => 'H Block',
                'total_beds'          => 12,
                'telephone_extension' => 'Extn. 7726',
            ],
            [
                'ward_name'           => 'Intensive Care',
                'location'            => 'A Block',
                'total_beds'          => 12,
                'telephone_extension' => 'Extn. 7727',
            ],
        ];

        DB::table('wards')->truncate();

        foreach ($wards as $ward) {
            DB::table('wards')->insert([
                ...$ward,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Seeded 17 wards (240 total beds).');
    }
}