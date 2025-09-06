<?php

declare(strict_types=1);

namespace App\Filament\Shared\Resources\Players\Schemas;

use Filament\Schemas\Schema;

final class PlayerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}
