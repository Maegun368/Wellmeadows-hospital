<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Give admin all existing permissions
        $allPermissions = Permission::all()->pluck('name')->toArray();
        if (!empty($allPermissions)) {
            $adminRole->syncPermissions($allPermissions);
        }

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@wellmeadows.com'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );

        $admin->assignRole('admin');

        $this->command->info('✅ Admin user seeded: admin@wellmeadows.com (password)');
    }
}
