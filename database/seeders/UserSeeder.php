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
        User::factory()->create([
            'name' => 'Super Admin User',
            'email' => 'super@super.com',
        ])->assignRole(RoleEnum::SUPER_ADMIN);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
        ])->assignRole(RoleEnum::ADMIN->value);

        User::factory()->create([
            'name' => 'Staff User',
            'email' => 'staff@staff.com',
        ])->assignRole([RoleEnum::STAFF->value]);

        User::factory()->create([
            'name' => 'Player User',
            'email' => 'player@player.com',
        ])->assignRole(RoleEnum::PLAYER->value);
    }
}
