<?php

namespace App\Filament\Shared\Resources\Players\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Shared\Resources\Players\PlayerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlayers extends ListRecords
{
    protected static string $resource = PlayerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
