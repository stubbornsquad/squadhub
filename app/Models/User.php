<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\PanelEnum;
use App\Enums\RoleEnum;
use BezhanSalleh\FilamentShield\FilamentShield;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Database\Factories\UserFactory;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

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
            PanelEnum::CLAN->value => $this->hasRole(RoleEnum::SUPER_ADMIN->value) || $this->hasRole(RoleEnum::STAFF->value),
            PanelEnum::PLAYER->value => $this->hasRole(RoleEnum::SUPER_ADMIN->value) || $this->hasRole(RoleEnum::PLAYER->value),
            default => false,
        };
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

    /**
     * Configuring the user's name attribute
     */
    //    public function getFilamentName(): string
    //    {
    //        return "{$this->nickname}";
    //    }

    //    public static function booted(): void
    //    {
    //        if (config('filament-shield.squadhub_admin_user.enabled', false)) {
    //            FilamentShield::createRole(config('filament-shield.squadhub_admin_user.name', 'admin'));
    //            User::created(fn($user) => $user->assignRole(config('filament-shield.squadhub_admin_user.name', 'admin')));
    //            User::deleted(fn($user) => $user->removeRole(config('filament-shield.squadhub_admin_user.name', 'admin')));
    //        }
    //
    //        if (config('filament-shield.clan_admin_user.enabled', false)) {
    //            FilamentShield::createRole(config('filament-shield.clan_admin_user.name', false));
    //            User::created(fn($user) => $user->assignRole(config('filament-shield.clan_admin_user.name', 'staff')));
    //            User::deleted(fn($user) => $user->removeRole(config('filament-shield.clan_admin_user.name', 'staff')));
    //        }
    //
    //        if (config('filament-shield.player_user.enabled', false)) {
    //            FilamentShield::createRole(config('filament-shield.player_user.name', 'player'));
    //            User::created(fn($user) => $user->assignRole(config('filament-shield.player_user.name', 'player')));
    //            User::deleted(fn($user) => $user->removeRole(config('filament-shield.player_user.name', 'player')));
    //        }
    //    }
}
