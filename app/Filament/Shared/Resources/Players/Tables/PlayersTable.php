<?php

namespace App\Filament\Shared\Resources\Players\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlayersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.nickname')
                    ->label('Nickname')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('steam_id')
                    ->label('Steam ID')
                    ->copyable()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('discord_user_id')
                    ->label('Discord ID')
                    ->copyable()
                    ->sortable()
                    ->searchable(),

                ImageColumn::make('avatar')
                    ->label('Avatar'),

                TextColumn::make('first_game_role')
                    ->label('Primary Role'),

                TextColumn::make('second_game_role')
                    ->label('Secondary Role'),

                TextColumn::make('first_gameplay_style')
                    ->label('Primary Style'),

                TextColumn::make('second_gameplay_style')
                    ->label('Secondary Style'),

                TextColumn::make('previous_teams')
                    ->label('Previous Teams')
                    ->badge()
                    ->separator()
                    ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : $state),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
