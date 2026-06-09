<?php

namespace App\Filament\Resources\AssetCategories\Schemas;

use App\Models\AssetCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AssetCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),

                Select::make('type')
                    ->label('Tipo')
                    ->required()
                    ->options(AssetCategory::TYPES)
                    ->columnSpan(1),

                Textarea::make('description')
                    ->label('Descripción')
                    ->rows(3)
                    ->maxLength(1000)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
