<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run(): void
{
    DB::table('staff')->insert([
        [
            'first_name'  => 'Dr. Ana',
            'last_name'   => 'Reyes',
            'position'    => 'Doctor',
            'email'       => 'ana.reyes@wellmeadows.com',
            'created_at'  => now(),
            'updated_at'  => now(),
        ],
    ]);
}
}
