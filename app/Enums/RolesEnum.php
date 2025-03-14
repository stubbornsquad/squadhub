<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RolesEnum: string implements HasLabel
{
    case ADMIN = 'admin'; // admin role contain access to all panels and all features
    case STAFF = 'staff'; // staff role contain access to staff panel and staff features
    case PLAYER = 'player'; // player role contain access to player panel and player features

    /**
     * Extra helper to allow for greater customization of displayed values,
     * without disclosing the name/value data directly.
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::STAFF => 'Staff',
            self::PLAYER => 'Player',
        };
    }
}
