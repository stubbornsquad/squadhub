<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\PanelsEnum;
use App\Enums\RolesEnum;
use BezhanSalleh\FilamentShield\FilamentShield;
use BezhanSalleh\FilamentShield\Support\Utils;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Database\Factories\UserFactory;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

final class User extends Authenticatable implements FilamentUser
{
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use HasPanelShield;

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
    public function canAccessPanel(Panel $panel, ): bool
    {
        return match ($panel->getId()) {
            RolesEnum::ADMIN->value => $this->hasRole(RolesEnum::ADMIN->value),
            RolesEnum::STAFF->value => $this->hasRole(RolesEnum::STAFF->value),
            RolesEnum::PLAYER->value => $this->hasRole(RolesEnum::PLAYER->value),
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
