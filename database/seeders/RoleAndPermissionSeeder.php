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
                    'view_user',
                    'view_any_user',
                    'create_user',
                    'update_user',
                    'restore_user',
                    'restore_any_user',
                    'replicate_user',
                    'reorder_user',
                    'delete_user',
                    'delete_any_user',
                    'force_delete_user',
                    'force_delete_any_user',

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
                    'create_role',
                    'update_role',
                    'delete_role',
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

    //        $roleModel = Utils::getRoleModel();
    //        $arrayRoleNames = RoleEnum::cases();
    //        $permissions = collect($arrayRoleNames)->map(function ($role) {
    //            return ['name' => $role, 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()];
    //        });
    //
    //        $roleModel::insert($permissions->toArray());
    //
    //
    //        $permissionModel = Utils::getPermissionModel();
    //        $arrayOfPermissionNames = static::makeGeneralResourcePermissionPrefixesWithEntity(['role', 'user']);
    //        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
    //            return ['name' => $permission, 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()];
    //        });
    //
    //        $permissionModel::insert($permissions->toArray());
    //    }

    //    private static function makeGeneralResourcePermissionPrefixesWithEntity(string|array $entity): array
    //    {
    //        $newArrayWithEntityName = [];
    //        $entities = is_array($entity) ? $entity : [$entity];
    //
    //        foreach ($entities as $entityItem) {
    //            foreach (Utils::getGeneralResourcePermissionPrefixes() as $prefix) {
    //                $newArrayWithEntityName[] = $prefix . '_' . $entityItem;
    //            }
    //        }
    //
    //        return $newArrayWithEntityName;
    //    }
}
