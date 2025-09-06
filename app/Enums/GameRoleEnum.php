<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum GameRoleEnum: string implements HasLabel
{
    case SL = 'Squad Leader';
    case RF = 'Rifleman';
    case MD = 'Medic';
    case MA = 'Marksman';
    case GL = 'Grenadier';
    case CE = 'Combat Engineer';
    case LMG = 'Light Machine Gunner';
    case MG = 'Machine Gunner';
    case LAT = 'Light Anti-Tank';
    case HAT = 'Heavy Anti-Tank';
    case PILOT = 'Pilot';
    case CREWG = 'Crewman Gunner';
    case CREWD = 'Crewman Driver';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::SL => 'Squad Leader',
            self::RF => 'Rifleman',
            self::MD => 'Medic',
            self::CE => 'Combat Engineer',
            self::LMG => 'Light Machine Gunner',
            self::MG => 'Machine Gunner',
            self::LAT => 'Light Anti-Tank',
            self::HAT => 'Heavy Anti-Tank',
            self::PILOT => 'Pilot',
            self::CREWD => 'Crewman Driver',
            self::CREWG => 'Crewman Gunner',
            self::MA => 'Marksman',
            self::GL => 'Grenadier',
        };
    }
}
