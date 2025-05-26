<?php

declare(strict_types=1);

namespace App\Filament\Shared\Resources\TeamResource\Pages;

use App\Filament\Shared\Resources\TeamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListTeams extends ListRecords
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
