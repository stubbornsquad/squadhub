<?php

declare(strict_types=1);

namespace App\Filament\Shared\Resources\Roles\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Shared\Resources\Roles\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
