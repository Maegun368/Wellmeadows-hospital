<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    DB::table('patients')->insert([
        [
            'first_name'     => 'Juan',
            'last_name'      => 'Dela Cruz',
            'age'            => 30,
            'gender'         => 'Male',
            'contact_number' => '09123456789',
            'address'        => 'Cagayan de Oro City',
            'blood_type'     => 'O+',
            'created_at'     => now(),
            'updated_at'     => now(),
        ],
        [
            'first_name'     => 'Maria',
            'last_name'      => 'Santos',
            'age'            => 25,
            'gender'         => 'Female',
            'contact_number' => '09987654321',
            'address'        => 'Iligan City',
            'blood_type'     => 'A+',
            'created_at'     => now(),
            'updated_at'     => now(),
        ],
    ]);
}
}
