<?php

namespace App\Filament\Resources\Departments\Schemas;

use App\Models\Department;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255)
                    ->unique(Department::class, 'name', ignoreRecord: true)
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
