<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PanelEnum;
use App\Enums\RoleEnum;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Carbon\CarbonImmutable;
use Database\Factories\UserFactory;
use DateTimeInterface;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $email
 * @property-read DateTimeInterface|null $email_verified_at
 * @property-read string $password
 * @property-read string|null $remember_token
 * @property-read CarbonImmutable $created_at
 * @property-read CarbonImmutable $updated_at
 */
final class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasPanelShield;
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Check if the user has access to a specific panel
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            PanelEnum::AUTH->value => true, // Added true fot have possibility get correct redirect based on user role in LoginResponse
            PanelEnum::SQUADHUB->value => $this->hasRole(RoleEnum::SUPER_ADMIN->value) || $this->hasRole(RoleEnum::ADMIN->value),
            PanelEnum::CLAN->value => $this->hasRole(RoleEnum::SUPER_ADMIN->value) || $this->hasRole(RoleEnum::ADMIN->value) || $this->hasRole(RoleEnum::STAFF->value),
            PanelEnum::PLAYER->value => $this->hasRole(RoleEnum::SUPER_ADMIN->value) || $this->hasRole(RoleEnum::ADMIN->value) || $this->hasRole(RoleEnum::STAFF->value) || $this->hasRole(RoleEnum::PLAYER->value),
            default => false,
        };
    }

    public function getFilamentAvatarUrl(): ?string
    {
        $avatarColumn = config('filament-edit-profile.avatar_column', 'avatar_url');

        return $this->$avatarColumn ? Storage::url(sprintf('%s->%s', $this, $avatarColumn)) : null;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
