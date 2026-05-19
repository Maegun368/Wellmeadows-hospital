<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // -------------------------------------------------------
        // 1. DEFINE ALL PERMISSIONS PER MODULE
        // -------------------------------------------------------
        $modules = [
            'dashboard',
            'patients',
            'appointments',
            'staff',
            'wards',
            'medications',
            'pharmaceuticals',
        ];

        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "$action $module"]);
            }
        }

        // -------------------------------------------------------
        // 2. CREATE ROLES
        // -------------------------------------------------------
        $medicalDirector  = Role::firstOrCreate(['name' => 'medical_director']);
        $personnelOfficer = Role::firstOrCreate(['name' => 'personnel_officer']);
        $chargeNurse      = Role::firstOrCreate(['name' => 'charge_nurse']);

        // -------------------------------------------------------
        // 3. ASSIGN PERMISSIONS TO ROLES
        // -------------------------------------------------------

        // --- MEDICAL DIRECTOR: view-only on everything ---
        $medicalDirector->syncPermissions([
            'view dashboard',
            'view patients',
            'view appointments',
            'view staff',
            'view wards',
            'view medications',
            'view pharmaceuticals',
        ]);

        // --- PERSONNEL OFFICER: full CRUD on staff, view on dashboard & wards ---
        $personnelOfficer->syncPermissions([
            'view dashboard',
            'view staff',
            'create staff',
            'edit staff',
            'delete staff',
            'view wards',
        ]);

        // --- CHARGE NURSE: full CRUD on clinical modules, view on staff ---
        $chargeNurse->syncPermissions([
            'view dashboard',
            'view patients',
            'create patients',
            'edit patients',
            'delete patients',
            'view appointments',
            'create appointments',
            'edit appointments',
            'delete appointments',
            'view staff',
            'view wards',
            'create wards',
            'edit wards',
            'delete wards',
            'view medications',
            'create medications',
            'edit medications',
            'delete medications',
            'view pharmaceuticals',
            'create pharmaceuticals',
            'edit pharmaceuticals',
            'delete pharmaceuticals',
        ]);

        $this->command->info('✅ Roles and permissions seeded successfully.');
    }
}