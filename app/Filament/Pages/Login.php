<?php

namespace App\Filament\Pages;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use SensitiveParameter;

class Login extends BaseLogin
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNickNameComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(#[SensitiveParameter] array $data): array
    {
        return [
            'nickname' => $data['nickname'],
            'password' => $data['password'],
        ];
    }

    private function getNickNameComponent(): TextInput
    {
        return TextInput::make('nickname')
            ->label('Nick Name')
            ->required()
            ->autofocus()
            ->placeholder('Your Nick Name')
            ->autocomplete('nick_name');
    }
}
