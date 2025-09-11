<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum GamePlayStyleEnum: string implements HasLabel
{
    case FLEX = 'flex';
    case FLANK = 'flank';
    case BACKDOOR = 'backdoor';
    case FRONTLINE = 'frontline';
    case BACKLINE = 'backline';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::FLEX => 'Flex',
            self::FLANK => 'Flank',
            self::BACKDOOR => 'Backdoor',
            self::FRONTLINE => 'Frontline',
            self::BACKLINE => 'Backline',
        };
    }
}
