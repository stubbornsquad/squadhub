<?php

declare(strict_types=1);

namespace App\Filament\Shared\Resources\Teams\Pages;

use App\Filament\Shared\Resources\Teams\TeamResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateTeam extends CreateRecord
{
    protected static string $resource = TeamResource::class;
}
