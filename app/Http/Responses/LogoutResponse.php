<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\LogoutResponse as BaseLogoutResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class LogoutResponse extends BaseLogoutResponse
{
    /**
     * Redirect the user after they have logged out.
     *
     * @param  Request  $request
     */
    public function toResponse($request): RedirectResponse
    {
        return redirect()->to('/login');
    }
}
