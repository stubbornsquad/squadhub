<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\GamePlayStyleEnum;
use App\Enums\GameRoleEnum;
use Carbon\CarbonImmutable;
use Database\Factories\PlayerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property int $user_id
 * @property string $steam_id
 * @property string|null $avatar
 * @property array|null $previous_teams
 * @property string $first_game_role
 * @property string $second_game_role
 * @property string $third_game_role
 * @property string $first_gameplay_style
 * @property string $second_gameplay_style
 * @property-read CarbonImmutable|null $joined_at
 * @property-read CarbonImmutable|null $created_at
 * @property-read CarbonImmutable|null $updated_at
 * @property-read User $user
 */
final class Player extends Model
{
    /** @use HasFactory<PlayerFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'first_game_role' => GameRoleEnum::class,
            'second_game_role' => GameRoleEnum::class,
            'third_game_role' => GameRoleEnum::class,
            'first_gameplay_style' => GamePlayStyleEnum::class,
            'second_gameplay_style' => GamePlayStyleEnum::class,
            'previous_teams' => 'array',
        ];
    }

    /*
     * Get the user that owns the player.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
