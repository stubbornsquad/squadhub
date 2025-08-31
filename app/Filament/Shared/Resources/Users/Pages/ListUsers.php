<?php

declare(strict_types=1);

namespace App\Filament\Shared\Resources\Users\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Shared\Resources\Users\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
