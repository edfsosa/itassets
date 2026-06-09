<?php

namespace App\Filament\Resources\MaintenanceRecords;

use App\Filament\Resources\MaintenanceRecords\Pages\CreateMaintenanceRecord;
use App\Filament\Resources\MaintenanceRecords\Pages\EditMaintenanceRecord;
use App\Filament\Resources\MaintenanceRecords\Pages\ListMaintenanceRecords;
use App\Filament\Resources\MaintenanceRecords\Schemas\MaintenanceRecordForm;
use App\Filament\Resources\MaintenanceRecords\Tables\MaintenanceRecordsTable;
use App\Models\MaintenanceRecord;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MaintenanceRecordResource extends Resource
{
    protected static ?string $model = MaintenanceRecord::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static ?string $recordTitleAttribute = 'type';

    protected static ?string $modelLabel = 'Mantenimiento';

    protected static ?string $pluralModelLabel = 'Mantenimientos';

    protected static ?string $navigationLabel = 'Mantenimientos';

    protected static \UnitEnum|string|null $navigationGroup = 'Inventario';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return MaintenanceRecordForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaintenanceRecordsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListMaintenanceRecords::route('/'),
            'create' => CreateMaintenanceRecord::route('/create'),
            'edit'   => EditMaintenanceRecord::route('/{record}/edit'),
        ];
    }
}
