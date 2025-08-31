<?php

declare(strict_types=1);

namespace App\Filament\Shared\Resources\Teams\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Shared\Resources\Teams\TeamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListTeams extends ListRecords
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
