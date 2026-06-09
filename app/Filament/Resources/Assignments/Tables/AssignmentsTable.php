<?php

namespace App\Filament\Resources\Assignments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssignmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset.asset_tag')
                    ->label('Código')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('asset.name')
                    ->label('Activo')
                    ->searchable()
                    ->limit(35),

                TextColumn::make('employee.name')
                    ->label('Empleado')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('employee.department')
                    ->label('Departamento')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('assigned_at')
                    ->label('Asignado el')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('returned_at')
                    ->label('Devuelto el')
                    ->date('d/m/Y')
                    ->placeholder('Activo')
                    ->sortable(),

                TextColumn::make('assigned_by')
                    ->label('Asignado por')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('active')
                    ->label('Solo activos (sin devolver)')
                    ->query(fn (Builder $query) => $query->whereNull('returned_at'))
                    ->toggle(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('assigned_at', 'desc');
    }
}
