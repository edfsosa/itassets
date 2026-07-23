<?php

namespace App\Filament\Resources\MaintenanceRecords\Pages;

use App\Filament\Resources\MaintenanceRecords\MaintenanceRecordResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMaintenanceRecord extends EditRecord
{
    protected static string $resource = MaintenanceRecordResource::class;

    protected ?string $pendingAssetStatus = null;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->pendingAssetStatus = $data['new_asset_status'] ?? null;
        unset($data['new_asset_status']);

        return $data;
    }

    protected function afterSave(): void
    {
        if ($this->pendingAssetStatus && $this->record->status === 'completed' && $this->record->asset) {
            $this->record->asset->update(['status' => $this->pendingAssetStatus]);
        }
    }
}
