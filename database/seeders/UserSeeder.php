<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'nickname' => 'Super Admin User',
        ])->assignRole(RoleEnum::SUPER_ADMIN);

        User::factory()->create([
            'nickname' => 'Staff User',
        ])->assignRole([RoleEnum::STAFF->value]);

        User::factory()->create([
            'nickname' => 'Player User',
        ])->assignRole(RoleEnum::PLAYER->value);
    }
}
