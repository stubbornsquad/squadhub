<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $adminPermissions = [
            'view_any_role',
            'view_role',
            'create_role',
            'update_role',
            'delete_role',
            'delete_any_role',
        ];

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
        ])->assignRole(RoleEnum::ADMIN->value)
            ->givePermissionTo($adminPermissions);


        $staffPermissions = [
            'view_role',
            'create_role',
            'update_role',
            'delete_role',
        ];

        User::factory()->create([
            'name' => 'Staff User',
            'email' => 'staff@staff.com',
        ])->assignRole([RoleEnum::STAFF->value])
            ->givePermissionTo($staffPermissions);


        User::factory()->create([
            'name' => 'Player User',
            'email' => 'player@player.com',
        ])->assignRole(RoleEnum::PLAYER->value);
    }
}
