<?php

namespace App\Filament\Resources\Suppliers\RelationManagers;

use App\Filament\Resources\Assets\AssetResource;
use App\Models\Asset;
use Filament\Actions\Action;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssetsRelationManager extends RelationManager
{
    protected static string $relationship = 'assets';

    protected static ?string $title = 'Activos';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('asset_tag')
                    ->label('Código')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (Asset $record): string => $record->getStatusLabel())
                    ->color(fn (Asset $record): string => $record->getStatusBadgeColor()),

                TextColumn::make('location.name')
                    ->label('Ubicación')
                    ->placeholder('—'),
            ])
            ->recordActions([
                Action::make('view')
                    ->label('Ver')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->url(fn (Asset $record) => AssetResource::getUrl('view', ['record' => $record])),
            ])
            ->defaultSort('asset_tag');
    }
}
