<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Medical Director
        $director = User::firstOrCreate(
            ['email' => 'director@wellmeadows.com'],
            [
                'name'     => 'Medical Director',
                'password' => Hash::make('password'),
            ]
        );
        $director->assignRole('medical_director');

        // Personnel Officer
        $officer = User::firstOrCreate(
            ['email' => 'officer@wellmeadows.com'],
            [
                'name'     => 'Personnel Officer',
                'password' => Hash::make('password'),
            ]
        );
        $officer->assignRole('personnel_officer');

        // Charge Nurse
        $nurse = User::firstOrCreate(
            ['email' => 'nurse@wellmeadows.com'],
            [
                'name'     => 'Charge Nurse',
                'password' => Hash::make('password'),
            ]
        );
        $nurse->assignRole('charge_nurse');

        $this->command->info('✅ Test users seeded:');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['medical_director',  'director@wellmeadows.com', 'password'],
                ['personnel_officer', 'officer@wellmeadows.com',  'password'],
                ['charge_nurse',      'nurse@wellmeadows.com',    'password'],
            ]
        );
    }
}