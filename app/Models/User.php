<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PanelEnum;
use App\Enums\RoleEnum;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Carbon\CarbonImmutable;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $nickname
 * @property string $email
 * @property CarbonImmutable|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 */
final class User extends Authenticatable implements FilamentUser, HasName
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasPanelShield;
    use HasRoles;
    use Notifiable;

    /**
     * @var array{
     *     password: string,
     *     remember_token: string
     * }
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return HasOne<Player, $this>
     */
    public function player(): HasOne
    {
        return $this->hasOne(Player::class);
    }

    /**
     * Check if the user has access to a specific panel
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            PanelEnum::AUTH->value => true, // Added true fot have possibility get correct redirect based on user role in LoginResponse
            PanelEnum::CLAN->value => $this->hasRole(RoleEnum::SUPER_ADMIN->value) || $this->hasRole(RoleEnum::STAFF->value),
            PanelEnum::PLAYER->value => $this->hasRole(RoleEnum::SUPER_ADMIN->value) || $this->hasRole(RoleEnum::STAFF->value) || $this->hasRole(RoleEnum::PLAYER->value),
            default => false,
        };
    }

    public function getFilamentName(): string
    {
        return $this->nickname;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'immutable_datetime',
            'password' => 'hashed',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];
    }
}
