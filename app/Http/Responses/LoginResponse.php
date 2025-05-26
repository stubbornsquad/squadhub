<?php

declare(strict_types=1);

namespace App\Http\Responses;

use App\Enums\PanelEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Filament\Http\Responses\Auth\LoginResponse as BaseLoginResponse;
use Filament\Pages\Dashboard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Livewire\Features\SupportRedirects\Redirector;

final class LoginResponse extends BaseLoginResponse
{
    /**
     * Redirect the user after they have logged in.
     *
     * @param  Request  $request
     */
    public function toResponse($request): Redirector|RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $targetPanel = match (true) {
            $user->hasRole(RoleEnum::SUPER_ADMIN->value) || $user->hasRole(RoleEnum::ADMIN->value) => PanelEnum::SQUADHUB->value,
            $user->hasRole(RoleEnum::SUPER_ADMIN->value) || $user->hasRole(RoleEnum::STAFF->value) => PanelEnum::CLAN->value,
            $user->hasRole(RoleEnum::SUPER_ADMIN->value) || $user->hasRole(RoleEnum::PLAYER->value) => PanelEnum::PLAYER->value,
            default => null,
        };

        if ($targetPanel) {
            return redirect()->to(Dashboard::getUrl(panel: $targetPanel));
        }

        return redirect()->to('/login');
    }
}
