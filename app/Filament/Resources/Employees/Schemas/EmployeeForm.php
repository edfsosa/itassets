<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Models\Employee;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre completo')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),

                TextInput::make('legajo')
                    ->label('Legajo')
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->columnSpan(1),

                TextInput::make('document_number')
                    ->label('Documento de identidad')
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->columnSpan(1),

                Select::make('status')
                    ->label('Estado')
                    ->required()
                    ->options(Employee::STATUSES)
                    ->default('active')
                    ->columnSpan(1),

                TextInput::make('department')
                    ->label('Departamento')
                    ->maxLength(100)
                    ->columnSpan(1),

                TextInput::make('position')
                    ->label('Cargo')
                    ->maxLength(100)
                    ->columnSpan(1),

                TextInput::make('email')
                    ->label('Correo electrónico')
                    ->email()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->columnSpan(1),

                TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel()
                    ->maxLength(30)
                    ->columnSpan(1),
            ])
            ->columns(2);
    }
}
