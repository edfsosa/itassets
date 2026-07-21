<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Models\Employee;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmployeeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información general')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nombre completo')
                            ->columnSpan(2),

                        TextEntry::make('legajo')
                            ->label('Legajo'),

                        TextEntry::make('document_number')
                            ->label('Documento de identidad'),

                        TextEntry::make('status')
                            ->label('Estado')
                            ->badge()
                            ->formatStateUsing(fn (Employee $record): string => $record->getStatusLabel())
                            ->color(fn (Employee $record): string => $record->getStatusBadgeColor()),

                        TextEntry::make('department')
                            ->label('Departamento')
                            ->placeholder('—'),

                        TextEntry::make('position')
                            ->label('Cargo')
                            ->placeholder('—'),

                        TextEntry::make('email')
                            ->label('Correo electrónico')
                            ->placeholder('—')
                            ->copyable(),

                        TextEntry::make('phone')
                            ->label('Teléfono')
                            ->placeholder('—'),
                    ])
                    ->columns(2),
            ]);
    }
}
