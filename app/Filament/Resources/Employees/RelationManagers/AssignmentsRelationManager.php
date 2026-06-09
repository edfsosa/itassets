<?php

namespace App\Filament\Resources\Employees\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assignments';

    protected static ?string $title = 'Activos asignados';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('asset.asset_tag')
                    ->label('Código')
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('asset.name')
                    ->label('Activo')
                    ->searchable(),

                TextColumn::make('asset.category.name')
                    ->label('Categoría')
                    ->badge(),

                TextColumn::make('assigned_at')
                    ->label('Asignado el')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('returned_at')
                    ->label('Devuelto el')
                    ->date('d/m/Y')
                    ->placeholder('Activo')
                    ->sortable(),

                TextColumn::make('notes')
                    ->label('Notas')
                    ->limit(40)
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('active')
                    ->label('Solo activos (sin devolver)')
                    ->query(fn (Builder $q) => $q->whereNull('returned_at'))
                    ->toggle()
                    ->default(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('assigned_at', 'desc');
    }
}
