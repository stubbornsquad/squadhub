<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum GameRoleEnum: string implements HasLabel
{
    case SL = 'squad-leader';
    case RF = 'rifleman';
    case MD = 'medic';
    case MA = 'marksman';
    case GL = 'grenadier';
    case CE = 'combat-engineer';
    case LMG = 'light-machine-gunner';
    case MG = 'machine-gunner';
    case LAT = 'light-anti-tank';
    case HAT = 'heavy-anti-tank';
    case PILOT = 'pilot';
    case CREWG = 'crewman-gunner';
    case CREWD = 'crewman-driver';

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
