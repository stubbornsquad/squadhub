<?php

namespace App\Filament\Pages;

use App\Enums\GamePlayStyleEnum;
use App\Enums\GameRoleEnum;
use App\Enums\RoleEnum;
use App\Http\Responses\RegistrationResponse;
use App\Models\Player;
use App\Models\User;
use Carbon\CarbonImmutable;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Auth\Events\Registered;
use Filament\Auth\Pages\Register;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;

class Registration extends Register
{
    public function getMaxContentWidth(): Width
    {
        return Width::TwoExtraLarge;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Your Profile')
                        ->schema([
                            $this->getNickNameFormComponent(),
                            $this->getSteamIdComponent(),
                            $this->getDiscordUserIdComponent(),
                            $this->getPreviousTeamsComponent(),
                        ]),
                    Wizard\Step::make('How You Play')
                        ->schema([
                            $this->getFirstGameRoleComponent(),
                            $this->getSecondGameRoleComponent(),
                            $this->getThirdGameRoleComponent(),
                            $this->getFirstGamePlayStyleComponent(),
                            $this->getSecondGamePlayStyleComponent(),
                        ]),
                    Wizard\Step::make('Password')
                        ->schema([
                            $this->getPasswordFormComponent(),
                            $this->getPasswordConfirmationFormComponent(),
                        ]),
                ])
//                    ->skippable()
                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button
                        type="submit"
                        size="sm"
                        wire:submit="register"
                    >
                        Register
                    </x-filament::button>
                    BLADE
                    ))),
            ]);
    }

    protected function getFormActions(): array
    {
        return [];
    }

    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $user = $this->wrapInDatabaseTransaction(function (): Model {
            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeRegister($data);

            $this->callHook('beforeRegister');

            $user = User::query()->create([
                'nickname' => $data['nickname'],
                'password' => Hash::make($data['password']),
            ]);

            $user->assignRole(RoleEnum::PLAYER->value);

            Player::query()->create([
                'user_id' => $user->id,
                'steam_id' => $data['steam_id'],
                'discord_user_id' => $data['discord_user_id'],
                'previous_teams' => $data['previous_teams'] ?? null,
                'first_game_role' => $data['first_game_role'],
                'second_game_role' => $data['second_game_role'],
                'third_game_role' => $data['third_game_role'],
                'first_gameplay_style' => $data['first_gameplay_style'],
                'second_gameplay_style' => $data['second_gameplay_style'],
                'joined_at' => CarbonImmutable::now(),
            ]);

            $this->form->model($user)->saveRelationships();

            $this->callHook('afterRegister');

            return $user;
        });

        event(new Registered($user));

        Filament::auth()->login($user);

        session()->regenerate();

        return app(RegistrationResponse::class);
    }


    private function getNickNameFormComponent(): TextInput
    {
        return TextInput::make('nickname')
            ->label(__('Nickname'))
            ->required()
            ->maxLength(100)
            ->autofocus();
    }

    private function getSteamIdComponent(): TextInput
    {
        return TextInput::make('steam_id')
            ->label('Steam ID')
            ->live()
            ->required()
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
//            ->required()
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
            ->label('Preferred Play Style')
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
