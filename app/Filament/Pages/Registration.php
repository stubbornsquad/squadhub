<?php

namespace App\Filament\Pages;

use Filament\Auth\Pages\Register;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Blade;
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
                    Wizard\Step::make('Contact')
                        ->schema([
                            $this->getNameFormComponent(),
                            $this->getEmailFormComponent(),
                        ]),
                    Wizard\Step::make('Social')
                        ->schema([
                            $this->getGithubFormComponent(),
                            $this->getTwitterFormComponent(),
                        ]),
                    Wizard\Step::make('Password')
                        ->schema([
                            $this->getPasswordFormComponent(),
                            $this->getPasswordConfirmationFormComponent(),
                        ]),
                ])->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button
                        type="submit"
                        size="sm"
                        wire:submit="register"
                    >
                        Register
                    </x-filament::button>
                    BLADE))),
            ]);
    }

    protected function getFormActions(): array
    {
        return [];
    }

    protected function getGithubFormComponent(): TextInput
    {
        return TextInput::make('github')
            ->prefix('https://github.com/')
            ->label(__('GitHub'))
            ->maxLength(255);
    }

    protected function getTwitterFormComponent(): TextInput
    {
        return TextInput::make('twitter')
            ->prefix('https://x.com/')
            ->label(__('Twitter (X)'))
            ->maxLength(255);
    }
}
