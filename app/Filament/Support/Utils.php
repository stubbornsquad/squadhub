<?php

namespace App\Filament\Support;

use App\Enums\PanelsEnum;
use App\Enums\RolesEnum;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard;

final class Utils
{
    public static function getPanelDashboardUrlBaseOnUser(): ?string
    {
            /** @var \App\Models\User $user */
            $user = Filament::auth()->user();

            $panelAdmin = Filament::getPanel(PanelsEnum::SQUADHUB->value);
            $panelClan = Filament::getPanel(PanelsEnum::CLAN->value);
            $panelPlayer = Filament::getPanel(PanelsEnum::PLAYER->value);

            if ($user->hasRole(RolesEnum::ADMIN)) {
                return true;
            }

            if ($user->hasRole(RolesEnum::STAFF)) {
                return true;
            }

            if ($user->hasRole(RolesEnum::PLAYER)) {
                return true;
            }

        return false;
    }
}
