<?php

namespace App\Http\Middleware;

use App\Enums\PanelsEnum;
use App\Enums\RolesEnum;
use BezhanSalleh\FilamentShield\Support\Utils;
use Closure;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Pages\Dashboard;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToProperPanelMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->hasRole(RolesEnum::ADMIN->value)) {
            return redirect()->to(Dashboard::getUrl(panel: PanelsEnum::SQUADHUB->value));
        }

        if (auth()->check() && auth()->user()->hasRole(RolesEnum::STAFF->value)) {
            return redirect()->to(Dashboard::getUrl(panel: PanelsEnum::CLAN->value));
        }

        if (auth()->user()->hasRole(RolesEnum::PLAYER->value)) {
            return redirect()->to(Dashboard::getUrl(panel: PanelsEnum::PLAYER->value));
        }

        return $next($request);
    }
}
