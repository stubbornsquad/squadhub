<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roleModel = Utils::getRoleModel();
        $arrayRoleNames = RoleEnum::cases();
        $permissions = collect($arrayRoleNames)->map(function ($role) {
            return ['name' => $role, 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()];
        });

        $roleModel::insert($permissions->toArray());


        $permissionModel = Utils::getPermissionModel();
        $arrayOfPermissionNames = static::makeGeneralResourcePermissionPrefixesWithEntity(['role', 'user']);
        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()];
        });

        $permissionModel::insert($permissions->toArray());
    }

    private static function makeGeneralResourcePermissionPrefixesWithEntity(string|array $entity): array
    {
        $newArrayWithEntityName = [];
        $entities = is_array($entity) ? $entity : [$entity];

        foreach ($entities as $entityItem) {
            foreach (Utils::getGeneralResourcePermissionPrefixes() as $prefix) {
                $newArrayWithEntityName[] = $prefix . '_' . $entityItem;
            }
        }

        return $newArrayWithEntityName;
    }
}
