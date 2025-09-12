<?php

declare(strict_types=1);

namespace App\Filament\Resources\Players\Pages;

use App\Enums\GamePlayStyleEnum;
use App\Enums\GameRoleEnum;
use App\Filament\Resources\Players\PlayerResource;
use App\Models\Player;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Hash;

final class EditPlayer extends EditRecord
{
    protected static string $resource = PlayerResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        $this->getNickNameFormComponent(),
                        $this->getPreviousTeamsComponent(),
                        $this->getSteamIdComponent(),
                        $this->getDiscordUserIdComponent(),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => fn(?Player $record) => $record === null ? 3 : 2]),

                Section::make()
                    ->schema([
                        TextEntry::make('created_at')
                            ->state(fn(Player $record): ?string => $record->created_at?->diffForHumans()),

                        TextEntry::make('updated_at')
                            ->label('Last modified at')
                            ->state(fn(Player $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn(?Player $record) => $record === null),

                Section::make()
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                $this->getFirstGameRoleComponent(),
                                $this->getSecondGameRoleComponent(),
                                $this->getThirdGameRoleComponent(),

                                $this->getFirstGamePlayStyleComponent(),
                                $this->getSecondGamePlayStyleComponent(),
                            ])
                    ])
                    ->columnSpanFull(),


                Section::make()
                    ->schema([
                        $this->getPasswordFormComponent(),
                    ]),
            ])
            ->columns(3);

    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        /** @var Player $record */
        $record = $this->getRecord();

        return 'Edit: ' . $record->user->nickname;
    }

    private function getNickNameFormComponent(): Grid
    {
        return Grid::make()
            ->relationship('user')
            ->schema([
                TextInput::make('nickname')
                    ->label(__('Nickname'))
                    ->maxLength(100)
                    ->unique()
                    ->autofocus()
                    ->columnSpanFull(),
            ]);
    }

    private function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->dehydrated(fn($state) => filled($state)) // Only include when a value exists
            ->required(fn(string $context): bool => $context === 'create')
            ->afterStateHydrated(fn(TextInput $component, $state) => $component->state($state?->password)) // Ensures edit form starts blank
            ->dehydrateStateUsing(fn($state) => Hash::make($state));
    }

    private function getSteamIdComponent(): TextInput
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

    private function getDiscordUserIdComponent(): TextInput
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

    private function getFirstGameRoleComponent(): Select
    {
        return Select::make('first_game_role')
            ->label('Primary Game Role')
            ->hint('What role do you primarily play in-game ?')
            ->options(GameRoleEnum::class)
            ->required();
    }

    private function getSecondGameRoleComponent(): Select
    {
        return Select::make('second_game_role')
            ->label('Secondary Game Role')
            ->hint('What role do you secondarily play in-game ?')
            ->options(GameRoleEnum::class)
            ->required();
    }

    private function getThirdGameRoleComponent(): Select
    {
        return Select::make('third_game_role')
            ->label('Tertiary Game Role')
            ->hint('What role do you tertiarily play in-game ?')
            ->options(GameRoleEnum::class)
            ->required();
    }

    private function getFirstGamePlayStyleComponent(): Select
    {
        return Select::make('first_gameplay_style')
            ->label('Preferred Play Style')
            ->hint('What is your primary preferred play style ?')
            ->options(GamePlayStyleEnum::class)
            ->required();
    }

    private function getSecondGamePlayStyleComponent(): Select
    {
        return Select::make('second_gameplay_style')
            ->label('Secondary Play Style')
            ->hint('What is your secondary preferred play style ?')
            ->options(GamePlayStyleEnum::class)
            ->required();
    }

    private function getPreviousTeamsComponent(): TagsInput
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
