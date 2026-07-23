<?php

use App\Filament\Resources\Assets\Pages\ViewAsset;
use App\Filament\Resources\Assets\RelationManagers\AssignmentsRelationManager as AssetAssignmentsRelationManager;
use App\Filament\Resources\Assets\RelationManagers\MaintenanceRecordsRelationManager;
use App\Filament\Resources\Employees\Pages\ViewEmployee;
use App\Filament\Resources\Employees\RelationManagers\AssignmentsRelationManager as EmployeeAssignmentsRelationManager;
use App\Filament\Resources\Licenses\Pages\ViewLicense;
use App\Filament\Resources\Licenses\RelationManagers\AssignmentsRelationManager as LicenseAssignmentsRelationManager;
use App\Models\Asset;
use App\Models\Employee;
use App\Models\License;
use App\Models\MaintenanceRecord;
use Livewire\Livewire;

it('denies viewer from creating an assignment via the asset relation manager', function () {
    $asset = Asset::factory()->create();
    loginAsViewer();

    Livewire::test(AssetAssignmentsRelationManager::class, [
        'ownerRecord' => $asset,
        'pageClass' => ViewAsset::class,
    ])->assertTableActionHidden('create');
});

it('hides the delete bulk action from editor on the asset assignments relation manager', function () {
    $asset = Asset::factory()->create();
    loginAsEditor();

    Livewire::test(AssetAssignmentsRelationManager::class, [
        'ownerRecord' => $asset,
        'pageClass' => ViewAsset::class,
    ])->assertTableBulkActionHidden('delete');
});

it('denies viewer from creating a maintenance record via the asset relation manager', function () {
    $asset = Asset::factory()->create();
    loginAsViewer();

    Livewire::test(MaintenanceRecordsRelationManager::class, [
        'ownerRecord' => $asset,
        'pageClass' => ViewAsset::class,
    ])->assertTableActionHidden('create');
});

it('hides the delete bulk action from editor on the maintenance records relation manager', function () {
    $asset = Asset::factory()->create();
    MaintenanceRecord::factory()->for($asset)->create();
    loginAsEditor();

    Livewire::test(MaintenanceRecordsRelationManager::class, [
        'ownerRecord' => $asset,
        'pageClass' => ViewAsset::class,
    ])->assertTableBulkActionHidden('delete');
});

it('denies viewer from assigning a license via the license relation manager', function () {
    $license = License::factory()->create();
    loginAsViewer();

    Livewire::test(LicenseAssignmentsRelationManager::class, [
        'ownerRecord' => $license,
        'pageClass' => ViewLicense::class,
    ])->assertTableActionHidden('create');
});

it('hides the delete bulk action from editor on the license assignments relation manager', function () {
    $license = License::factory()->create();
    loginAsEditor();

    Livewire::test(LicenseAssignmentsRelationManager::class, [
        'ownerRecord' => $license,
        'pageClass' => ViewLicense::class,
    ])->assertTableBulkActionHidden('delete');
});

it('hides the delete bulk action from editor on the employee assignments relation manager', function () {
    $employee = Employee::factory()->create();
    loginAsEditor();

    Livewire::test(EmployeeAssignmentsRelationManager::class, [
        'ownerRecord' => $employee,
        'pageClass' => ViewEmployee::class,
    ])->assertTableBulkActionHidden('delete');
});
