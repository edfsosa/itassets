<?php

use App\Filament\Resources\Assets\Pages\ViewAsset;
use App\Filament\Resources\Assets\RelationManagers\AssignmentsRelationManager as AssetAssignmentsRelationManager;
use App\Filament\Resources\Assets\RelationManagers\MaintenanceRecordsRelationManager;
use App\Filament\Resources\Licenses\Pages\ViewLicense;
use App\Filament\Resources\Licenses\RelationManagers\AssignmentsRelationManager as LicenseAssignmentsRelationManager;
use App\Models\Asset;
use App\Models\License;
use Livewire\Livewire;

beforeEach(function () {
    loginAsAdmin();
});

it('shows the create action on the asset assignments relation manager from the View page', function () {
    $asset = Asset::factory()->create();

    Livewire::test(AssetAssignmentsRelationManager::class, [
        'ownerRecord' => $asset,
        'pageClass' => ViewAsset::class,
    ])->assertTableActionVisible('create');
});

it('shows the create action on the maintenance records relation manager from the View page', function () {
    $asset = Asset::factory()->create();

    Livewire::test(MaintenanceRecordsRelationManager::class, [
        'ownerRecord' => $asset,
        'pageClass' => ViewAsset::class,
    ])->assertTableActionVisible('create');
});

it('shows the create action on the license assignments relation manager from the View page', function () {
    $license = License::factory()->create();

    Livewire::test(LicenseAssignmentsRelationManager::class, [
        'ownerRecord' => $license,
        'pageClass' => ViewLicense::class,
    ])->assertTableActionVisible('create');
});
