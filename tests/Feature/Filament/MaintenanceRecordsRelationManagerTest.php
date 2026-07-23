<?php

use App\Filament\Resources\Assets\Pages\ViewAsset;
use App\Filament\Resources\Assets\RelationManagers\MaintenanceRecordsRelationManager;
use App\Models\Asset;
use App\Models\MaintenanceRecord;
use Livewire\Livewire;

beforeEach(function () {
    loginAsAdmin();
});

it('allows setting notes from the maintenance records relation manager', function () {
    $asset = Asset::factory()->create();
    $record = MaintenanceRecord::factory()->inProgress()->for($asset)->create(['notes' => null]);

    Livewire::test(MaintenanceRecordsRelationManager::class, [
        'ownerRecord' => $asset,
        'pageClass' => ViewAsset::class,
    ])
        ->mountTableAction('edit', $record)
        ->setTableActionData(['notes' => 'Revisado por el proveedor'])
        ->callMountedTableAction()
        ->assertHasNoTableActionErrors();

    expect($record->fresh()->notes)->toBe('Revisado por el proveedor');
});

it('lets the user choose the resulting asset status when completing via the relation manager', function () {
    $asset = Asset::factory()->maintenance()->create();
    $record = MaintenanceRecord::factory()->inProgress()->for($asset)->create();

    Livewire::test(MaintenanceRecordsRelationManager::class, [
        'ownerRecord' => $asset,
        'pageClass' => ViewAsset::class,
    ])
        ->mountTableAction('edit', $record)
        ->setTableActionData([
            'status' => 'completed',
            'new_asset_status' => 'lost',
            'completed_at' => now()->toDateString(),
        ])
        ->callMountedTableAction()
        ->assertHasNoTableActionErrors();

    expect($asset->fresh()->status)->toBe('lost');
});
