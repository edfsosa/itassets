<?php

namespace App\Filament\Resources\AssetCategories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AssetCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información general')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nombre')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Section::make('Descripción')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextEntry::make('description')
                            ->label('')
                            ->placeholder('Sin descripción')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
