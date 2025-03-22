<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RoleEnum: string implements HasLabel
{
    case SUPER_ADMIN = 'super_admin'; // super admin role contain access to all panels and all features
    case ADMIN = 'admin'; // admin role contain access to admin, staff, player panel and admin, staff, player features
    case STAFF = 'staff'; // staff role contain access to staff, player panel and staff, player features
    case PLAYER = 'player'; // player role contain access to player panel and player features

    /**
     * Extra helper to allow for greater customization of displayed values,
     * without disclosing the name/value data directly.
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::ADMIN => 'Admin',
            self::STAFF => 'Staff',
            self::PLAYER => 'Player',
        };
    }
}
