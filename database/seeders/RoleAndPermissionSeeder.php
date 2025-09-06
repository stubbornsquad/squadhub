<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

final class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define Roles with Associated Permissions
        $rolesWithPermissions = [
            [
                'name' => RoleEnum::SUPER_ADMIN->value,
                'guard_name' => 'web',
                'permissions' => [
                    // User resource permissions
                    'view_player',
                    'view_any_player',
                    'create_player',
                    'update_player',
                    'restore_player',
                    'restore_any_player',
                    'replicate_player',
                    'reorder_player',
                    'delete_player',
                    'delete_any_player',
                    'force_delete_player',
                    'force_delete_any_player',

                    // Role resource permissions
                    'view_role',
                    'view_any_role',
                    'create_role',
                    'update_role',
                    'restore_role',
                    'restore_any_role',
                    'replicate_role',
                    'reorder_role',
                    'delete_role',
                    'delete_any_role',
                    'force_delete_role',
                    'force_delete_any_role',
                ],
            ],
            [
                'name' => RoleEnum::ADMIN->value,
                'guard_name' => 'web',
                'permissions' => [
                    'view_any_role',
                    'view_role',
                    'create_role',
                    'update_role',
                    'delete_role',
                    'delete_any_role',
                ],
            ],
            [
                'name' => RoleEnum::STAFF->value,
                'guard_name' => 'web',
                'permissions' => [
                    'view_role',
                    'create_role',
                    'update_role',
                    'delete_role',
                ],
            ],

            [
                'name' => RoleEnum::PLAYER->value,
                'guard_name' => 'web',
                'permissions' => [
                    'view_role',
                ],
            ],
        ];

        // Create Roles and Assign Permissions
        foreach ($rolesWithPermissions as $roleData) {
            $role = Role::firstOrCreate([
                'name' => $roleData['name'],
                'guard_name' => $roleData['guard_name'],
            ]);

            $permissions = collect($roleData['permissions'])
                ->map(fn ($permissionName) => Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => $roleData['guard_name'],
                ]))
                ->all();

            $role->syncPermissions($permissions);
        }
    }
}
