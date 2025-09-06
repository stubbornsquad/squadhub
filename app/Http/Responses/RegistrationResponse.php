<?php

declare(strict_types=1);

namespace App\Http\Responses;

use App\Enums\PanelEnum;
use App\Enums\RoleEnum;
use Filament\Auth\Http\Responses\Contracts\RegistrationResponse as BaseRegistrationResponse;
use Filament\Pages\Dashboard;

class RegistrationResponse implements BaseRegistrationResponse
{
    public function toResponse($request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('filament.login');
        }

        $targetPanel = match (true) {
            $user->hasAnyRole([RoleEnum::SUPER_ADMIN->value, RoleEnum::STAFF->value]) => PanelEnum::CLAN->value,
            $user->hasAnyRole([RoleEnum::SUPER_ADMIN->value, RoleEnum::PLAYER->value]) => PanelEnum::PLAYER->value,
            default => null,
        };

        if ($targetPanel) {
            return redirect()->to(Dashboard::getUrl(panel: $targetPanel));
        }

        return redirect()->route('filament.register');
    }
}
