<?php

namespace App\Enums;


use Filament\Support\Contracts\HasLabel;

enum PanelsEnum: string implements HasLabel
{
    case AUTH = 'auth';
    case SQUADHUB = 'admin';
    case CLAN = 'staff';
    case PLAYER = 'player';

    /**
     * Extra helper to allow for greater customization of displayed values,
     * without disclosing the name/value data directly.
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::SQUADHUB => 'SquadHub',
            self::CLAN => 'Clan',
            self::PLAYER => 'Player',
        };
    }
}
