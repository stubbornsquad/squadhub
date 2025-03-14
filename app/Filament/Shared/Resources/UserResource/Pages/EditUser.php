<?php

declare(strict_types=1);

namespace app\Filament\Shared\Resources\UserResource\Pages;

use app\Filament\Shared\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
