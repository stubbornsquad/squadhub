<?php

declare(strict_types=1);

namespace App\Filament\Shared\Resources\Roles\Pages;

use Filament\Actions\EditAction;
use App\Filament\Shared\Resources\Roles\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

final class ViewRole extends ViewRecord
{
    protected static string $resource = RoleResource::class;

    protected function getActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
