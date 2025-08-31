<?php

declare(strict_types=1);

namespace App\Filament\Shared\Resources\Teams\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Shared\Resources\Teams\TeamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditTeam extends EditRecord
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
