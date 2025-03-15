<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminUser = User::factory()->create([
            'name' => 'SmereKa',
            'email' => 'admin@admin.com',
        ]);
        $adminRole = Role::create(['name' => 'admin']);
        $adminUser->assignRole([$adminRole]);

        $adminPermissions = [
            'view_any_role',
            'view_role',
            'create_role',
            'update_role',
            'delete_role',
            'delete_any_role',
        ];

        foreach ($adminPermissions as $permissionName) {
            Permission::create([
                'name' => $permissionName,
            ]);
        }

        $adminRole->givePermissionTo($adminPermissions);

        $staffUser = User::factory()->create([
            'name' => 'Bona',
            'email' => 'staff@staff.com',
        ]);

        $staffRole = Role::create(['name' => 'staff']);
        $staffUser->assignRole([$staffRole]);

        $staffPermissions = [
            'view_role',
            'create_role',
            'update_role',
            'delete_role',
        ];
        $staffRole->givePermissionTo($staffPermissions);

        $playerUser = User::factory()->create([
            'name' => 'Mona',
            'email' => 'player@player.com',
        ]);
        $playerRole = Role::create(['name' => 'player']);
        $playerUser->assignRole([$playerRole]);
    }
}
