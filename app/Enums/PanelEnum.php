<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PanelEnum: string implements HasLabel
{
    case AUTH = 'auth';
    case TEAM = 'team';
    case PLAYER = 'player';

    /**
     * Extra helper to allow for greater customization of displayed values,
     * without disclosing the name/value data directly.
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::AUTH => 'Auth',
            self::TEAM => 'Team',
            self::PLAYER => 'Player',
        };
    }

    public function getPanelLabel(): string
    {
        return $this->getLabel() . ' Panel';
    }
}
