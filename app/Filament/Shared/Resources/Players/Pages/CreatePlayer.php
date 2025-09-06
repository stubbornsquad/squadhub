<?php

declare(strict_types=1);

namespace App\Filament\Shared\Resources\Players\Pages;

use App\Enums\RoleEnum;
use App\Filament\Shared\Resources\Players\PlayerResource;
use App\Models\Player;
use App\Models\User;
use Carbon\CarbonImmutable;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

final class CreatePlayer extends CreateRecord
{
    protected static string $resource = PlayerResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Create User first
        $user = User::query()->create([
            'nickname' => $data['nickname'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole(RoleEnum::PLAYER->value);

        // Then create Player linked to User
        return Player::query()->create([
            'user_id' => $user->id,
            'steam_id' => $data['steam_id'],
            'discord_user_id' => $data['discord_user_id'],
            'previous_teams' => $data['previous_teams'] ?? null,
            'first_game_role' => $data['first_game_role'],
            'second_game_role' => $data['second_game_role'],
            'third_game_role' => $data['third_game_role'],
            'first_gameplay_style' => $data['first_gameplay_style'],
            'second_gameplay_style' => $data['second_gameplay_style'],
            'joined_at' => CarbonImmutable::now(),
        ]);
    }
}
