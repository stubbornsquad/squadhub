<?php

namespace App\Filament\Shared\Resources\Players\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Shared\Resources\Players\PlayerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlayer extends EditRecord
{
    protected static string $resource = PlayerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
