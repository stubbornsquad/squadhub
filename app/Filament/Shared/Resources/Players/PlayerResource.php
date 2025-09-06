<?php

declare(strict_types=1);

namespace App\Filament\Shared\Resources\Players;

use App\Filament\Shared\Resources\Players\Pages\CreatePlayer;
use App\Filament\Shared\Resources\Players\Pages\EditPlayer;
use App\Filament\Shared\Resources\Players\Pages\ListPlayers;
use App\Filament\Shared\Resources\Players\Pages\ViewPlayer;
use App\Filament\Shared\Resources\Players\Schemas\PlayerForm;
use App\Filament\Shared\Resources\Players\Schemas\PlayerInfolist;
use App\Filament\Shared\Resources\Players\Tables\PlayersTable;
use App\Models\Player;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class PlayerResource extends Resource
{
    protected static ?string $model = Player::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PlayerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlayersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlayers::route('/'),
            'create' => CreatePlayer::route('/create'),
            'edit' => EditPlayer::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['user.nickname'];
    }
}
