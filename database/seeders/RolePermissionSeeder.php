<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            ['name' => 'view-users', 'description' => 'View users list'],
            ['name' => 'create-user', 'description' => 'Create new user'],
            ['name' => 'update-user', 'description' => 'Update user'],
            ['name' => 'delete-user', 'description' => 'Delete user'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name']], $permission);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Administrator with full access']
        );

        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            ['description' => 'Regular user with limited access']
        );

        // Assign all permissions to admin
        $allPermissions = Permission::all();
        $adminRole->permissions()->sync($allPermissions->pluck('id'));

        // Assign view permission to user role
        $viewPermission = Permission::where('name', 'view-users')->first();
        $userRole->permissions()->sync([$viewPermission->id]);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->roles()->sync([$adminRole->id]);

        // Create regular user
        $regularUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password123'),
            ]
        );
        $regularUser->roles()->sync([$userRole->id]);
    }
}
