<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Traits\HasPermissions;

class SuperAdminUserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin User',
            'email' => 'super@super.com',
        ])->assignRole(RoleEnum::SUPER_ADMIN)
            ->givePermissionTo([ // User permissions
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
            ])->givePermissionTo([ // Role permissions
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
            ]);
    }
}
