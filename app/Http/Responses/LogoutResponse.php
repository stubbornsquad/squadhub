<?php

namespace App\Http\Responses;

use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Filament\Http\Responses\Auth\LogoutResponse as BaseLogoutResponse;
use Illuminate\Http\Request;

class LogoutResponse extends BaseLogoutResponse
{
    /**
     * Redirect the user after they have logged out.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function toResponse($request): RedirectResponse
    {
        return redirect()->to('/login');
    }
}
