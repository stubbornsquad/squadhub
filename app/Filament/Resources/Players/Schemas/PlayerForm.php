<?php

declare(strict_types=1);

namespace App\Filament\Resources\Players\Schemas;

use App\Enums\GamePlayStyleEnum;
use App\Enums\GameRoleEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

final class PlayerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Wizard\Step::make('Player Profile')
                        ->schema([
                            self::getNickNameFormComponent(),
                            self::getSteamIdComponent(),
                            self::getDiscordUserIdComponent(),
                            self::getPreviousTeamsComponent(),
                        ]),
                    Wizard\Step::make('How Player Play')
                        ->schema([
                            self::getFirstGameRoleComponent(),
                            self::getSecondGameRoleComponent(),
                            self::getThirdGameRoleComponent(),
                            self::getFirstGamePlayStyleComponent(),
                            self::getSecondGamePlayStyleComponent(),
                        ]),
                    Wizard\Step::make('Password')
                        ->schema([
                            self::getPasswordFormComponent(),
                            self::getPasswordConfirmationFormComponent(),
                        ]),
                ]),
            ])
            ->columns(1);
    }

    private static function getNickNameFormComponent(): TextInput
    {
        return TextInput::make('nickname')
            ->label(__('Nickname'))
            ->required()
            ->maxLength(100)
            ->autofocus();
    }

    private static function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::auth/pages/register.form.password.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->rule(Password::default())
            ->showAllValidationMessages()
            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
            ->same('passwordConfirmation')
            ->validationAttribute(__('filament-panels::auth/pages/register.form.password.validation_attribute'));
    }

    private static function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->label(__('filament-panels::auth/pages/register.form.password_confirmation.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->dehydrated(false);
    }

    private static function getSteamIdComponent(): TextInput
    {
        return TextInput::make('steam_id')
            ->label('Steam ID')
            ->live()
            ->required()
            ->unique()
            ->hint('Paste your numeric Steam ID or full profile URL')
            ->afterStateUpdated(function (Set $set, ?string $state) {
                if ($state) {
                    // Extract numeric Steam ID using regex
                    if (preg_match('/\d{17,}/', $state, $matches)) {
                        $set('steam_id', $matches[0]);
                    }
                }
            })
            ->rule('numeric')
            ->rule('digits:17');

    }

    private static function getDiscordUserIdComponent(): TextInput
    {
        return TextInput::make('discord_user_id')
            ->label('Discord User ID')
            ->live()
            ->required()
            ->unique()
            ->hint('Enable Developer Mode in Discord, then right-click your username and select "Copy ID"')
            ->afterStateUpdated(function (Set $set, ?string $state) {
                if ($state) {
                    // Extract numeric Discord User ID using regex
                    if (preg_match('/\d{18,}/', $state, $matches)) {
                        $set('discord_user_id', $matches[0]);
                    }
                }
            })
            ->rule('numeric')
            ->rule('digits:18');
    }

    private static function getFirstGameRoleComponent(): Select
    {
        return Select::make('first_game_role')
            ->label('Primary Game Role')
            ->hint('What role do you primarily play in-game ?')
            ->options(GameRoleEnum::class)
            ->required();
    }

    private static function getSecondGameRoleComponent(): Select
    {
        return Select::make('second_game_role')
            ->label('Secondary Game Role')
            ->hint('What role do you secondarily play in-game ?')
            ->options(GameRoleEnum::class)
            ->required();
    }

    private static function getThirdGameRoleComponent(): Select
    {
        return Select::make('third_game_role')
            ->label('Tertiary Game Role')
            ->hint('What role do you tertiarily play in-game ?')
            ->options(GameRoleEnum::class)
            ->required();
    }

    private static function getFirstGamePlayStyleComponent(): Select
    {
        return Select::make('first_gameplay_style')
            ->label('Preferred Play Style')
            ->hint('What is your primary preferred play style ?')
            ->options(GamePlayStyleEnum::class)
            ->required();
    }

    private static function getSecondGamePlayStyleComponent(): Select
    {
        return Select::make('second_gameplay_style')
            ->label('Preferred Play Style')
            ->hint('What is your secondary preferred play style ?')
            ->options(GamePlayStyleEnum::class)
            ->required();
    }

    private static function getPreviousTeamsComponent(): TagsInput
    {
        return TagsInput::make('previous_teams')
            ->label('Previous Teams')
            ->hint('Add your previous teams or clans (press Enter after each)')
            ->separator(',')
            ->suggestions(['RATS', 'WG', 'LD', '450'])
            ->placeholder('Type abbreviation and press Enter')
            ->validationAttribute('previous team')
            ->rules([
                'array',
                'distinct', // no duplicates
            ])
            ->nestedRecursiveRules([
                'max:10', // max 10 characters per tag
                'alpha_num', // only alphanumeric characters
                'string',
            ]);
    }
}
