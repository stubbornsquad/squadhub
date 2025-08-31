<?php

declare(strict_types=1);

namespace App\Filament\Shared\Resources\Teams;

use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Shared\Resources\Teams\Pages\ListTeams;
use App\Filament\Shared\Resources\Teams\Pages\CreateTeam;
use App\Filament\Shared\Resources\Teams\Pages\EditTeam;
use App\Filament\Shared\Resources\TeamResource\Pages;
use App\Models\Team;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
                Select::make('primary_language')
                    ->options([
                        'draft' => 'Draft',
                        'reviewing' => 'Reviewing',
                        'published' => 'Published',
                    ]),
                TextInput::make('slug'),
                Select::make('region')
                    ->options([
                        'draft' => 'Draft',
                        'reviewing' => 'Reviewing',
                        'published' => 'Published',
                    ]),
                TextInput::make('tag'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tag')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('region')
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('recruitment_status')
                    ->label('Recruiting')
                    ->sortable(),
                TextColumn::make('founded_in')->dateTime('Y')
                    ->sortable(),
                TextColumn::make('created_at')->dateTime('Y-m-d')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => ListTeams::route('/'),
            'create' => CreateTeam::route('/create'),
            'edit' => EditTeam::route('/{record}/edit'),
        ];
    }
}
