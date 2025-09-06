<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum GamePlayStyleEnum: string implements HasLabel
{
    case FLEX = 'Flex';
    case FLANK = 'Flank';
    case BACKDOOR = 'Backdoor';
    case FRONTLINE = 'Frontline';
    case BACKLINE = 'Backline';

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
