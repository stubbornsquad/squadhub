<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\PanelEnum;
use App\Enums\RoleEnum;
use BezhanSalleh\FilamentShield\FilamentShield;
use BezhanSalleh\PanelSwitch\PanelSwitch;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * @var array<string, string>
     */
    public array $singletons = [
        \Filament\Http\Responses\Auth\Contracts\LoginResponse::class => \App\Http\Responses\LoginResponse::class,
        \Filament\Http\Responses\Auth\Contracts\LogoutResponse::class => \App\Http\Responses\LogoutResponse::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->enableSuperAdminAccess();
        $this->configureCommands();
        $this->configureDates();
        $this->configureModels();
        $this->configureUrls();
        $this->configureVite();
        $this->configurePanelSwitchPlugin();

    }

    /**
     * Configure the application's commands.
     */
    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->isProduction(),
        );
        FilamentShield::prohibitDestructiveCommands(
            $this->app->isProduction()
        );
    }

    /**
     * Configure the application's dates.
     */
    private function configureDates(): void
    {
        Date::use(CarbonImmutable::class);
    }

    /**
     * Configure the application's models.
     */
    private function configureModels(): void
    {
        Model::unguard();
        Model::shouldBeStrict();
    }

    /**
     * Configure the application's URLs.
     */
    private function configureUrls(): void
    {
        //        URL::forceScheme('https');
    }

    /**
     * Configure the application's Vite instance.
     */
    private function configureVite(): void
    {
        Vite::useAggressivePrefetching();
    }

    /**
     * Enable super admin access.
     */
    private function enableSuperAdminAccess(): void
    {
        Gate::before(fn ($user, $ability): ?true => $user->hasRole(RoleEnum::SUPER_ADMIN) ? true : null);
    }

    /**
     * Configure the PanelSwitch plugin.
     *
     * @url https://filamentphp.com/plugins/bezhansalleh-panel-switch
     */
    private function configurePanelSwitchPlugin(): void
    {
        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch): void {
            $panelSwitch
                ->visible(fn (): bool => ! auth()->user()?->hasAnyRole(RoleEnum::PLAYER)) // Hide the panel switcher for players
                ->panels(
                    function () {
                        // Super Admins and Admins can access all panels
                        if (auth()->user()?->hasAnyRole([RoleEnum::SUPER_ADMIN, RoleEnum::ADMIN])) {
                            return [
                                PanelEnum::SQUADHUB->value,
                                PanelEnum::CLAN->value,
                                PanelEnum::PLAYER->value,
                            ];
                        }

                        // Staff can access the staff and player panels
                        if (auth()->user()?->hasAnyRole([RoleEnum::STAFF])) {
                            return [
                                PanelEnum::CLAN->value,
                                PanelEnum::PLAYER->value,
                            ];
                        }
                    })
                ->modalHeading('Available Panels')
                ->modalWidth('sm')
                ->slideOver()
                ->icons([
                    PanelEnum::SQUADHUB->value => 'heroicon-o-square-2-stack',
                    PanelEnum::CLAN->value => 'heroicon-o-star',
                    PanelEnum::PLAYER->value => 'heroicon-o-star',
                ])
                ->iconSize(16)
                ->labels([
                    PanelEnum::SQUADHUB->value => 'SquadHub Panel',
                    PanelEnum::CLAN->value => 'Clan Panel',
                    PanelEnum::PLAYER->value => 'Player Panel',
                ]);
        });
    }
}
