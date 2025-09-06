<?php

declare(strict_types=1);

namespace App\Filament\Shared\Resources\Players\Pages;

use App\Filament\Shared\Resources\Players\PlayerResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewPlayer extends ViewRecord
{
    protected static string $resource = PlayerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
