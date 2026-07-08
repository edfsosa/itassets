<?php

use App\Exports\AssetsExport;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Location;
use App\Models\Supplier;

beforeEach(function () {
    loginAsAdmin();
});

it('exports assets with headings', function () {
    Asset::factory()->count(3)->create();

    $export = new AssetsExport;
    $headings = $export->headings();

    expect($headings)->toContain('Código', 'Nombre', 'Categoría', 'Estado');
});

it('filters assets by status', function () {
    Asset::factory()->count(3)->available()->create();
    Asset::factory()->count(2)->maintenance()->create();

    $export = new AssetsExport(status: 'maintenance');
    $results = $export->query()->get();

    expect($results->count())->toBe(2);
});

it('filters assets by category', function () {
    $cat1 = AssetCategory::factory()->create();
    $cat2 = AssetCategory::factory()->create();
    Asset::factory()->count(3)->create(['asset_category_id' => $cat1->id]);
    Asset::factory()->count(2)->create(['asset_category_id' => $cat2->id]);

    $export = new AssetsExport(categoryId: $cat1->id);
    $results = $export->query()->get();

    expect($results->count())->toBe(3);
});

it('maps asset data correctly', function () {
    $supplier = Supplier::factory()->create(['name' => 'Test Supplier']);
    $location = Location::factory()->create(['name' => 'Test Location']);
    $category = AssetCategory::factory()->hardware()->create();

    $asset = Asset::factory()->available()->create([
        'asset_tag'          => 'IT-0001',
        'name'               => 'Test Asset',
        'asset_category_id'  => $category->id,
        'brand'              => 'TestBrand',
        'supplier_id'        => $supplier->id,
        'location_id'        => $location->id,
    ]);

    $export = new AssetsExport;
    $mapped = $export->map($asset);

    expect($mapped[0])->toBe('IT-0001');
    expect($mapped[1])->toBe('Test Asset');
    expect($mapped[2])->toBe('Hardware');
    expect($mapped[3])->toBe('TestBrand');
});
