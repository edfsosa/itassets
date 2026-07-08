<?php

use App\Imports\AssetImport;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Location;
use App\Models\Supplier;
use Maatwebsite\Excel\Facades\Excel;

beforeEach(function () {
    loginAsAdmin();

    AssetCategory::factory()->create(['name' => 'Hardware', 'type' => 'hardware']);
    Supplier::factory()->create(['name' => 'Tech Distribuidora']);
    Location::factory()->create(['name' => 'Oficina Central']);
});

it('imports a new asset from row', function () {
    $import = new AssetImport;

    $import->model([
        'asset_tag'       => 'IT-9999',
        'nombre'          => 'Test Laptop',
        'categoria'       => 'Hardware',
        'marca'           => 'HP',
        'modelo'          => 'ProBook',
        'numero_de_serie' => 'SN001',
        'estado'          => 'Disponible',
        'ubicacion'       => 'Oficina Central',
        'fecha_de_compra' => '15/01/2026',
        'proveedor'       => 'Tech Distribuidora',
        'costo'           => '15000.00',
    ]);

    $asset = Asset::where('asset_tag', 'IT-9999')->first();
    expect($asset)->not->toBeNull();
    expect($asset->name)->toBe('Test Laptop');
    expect($asset->brand)->toBe('HP');
    expect($asset->status)->toBe('available');
});

it('updates existing asset by tag', function () {
    Asset::factory()->create(['asset_tag' => 'IT-0001', 'name' => 'Old Name']);

    $import = new AssetImport;
    $import->model([
        'asset_tag'       => 'IT-0001',
        'nombre'          => 'Updated Name',
        'categoria'       => 'Hardware',
        'marca'           => '',
        'modelo'          => '',
        'numero_de_serie' => '',
        'estado'          => 'Asignado',
        'ubicacion'       => '',
        'fecha_de_compra' => '',
        'proveedor'       => '',
        'costo'           => '',
    ]);

    $asset = Asset::where('asset_tag', 'IT-0001')->first();
    expect($asset->name)->toBe('Updated Name');
});

it('normalizes spanish statuses', function () {
    $import = new AssetImport;

    $statuses = [
        'Disponible'       => 'available',
        'Asignado'         => 'assigned',
        'En mantenimiento' => 'maintenance',
        'Dado de baja'     => 'retired',
        'Perdido'          => 'lost',
        'En stock'         => 'stock',
        'Almacén'          => 'stock',
    ];

    foreach ($statuses as $input => $expected) {
        Asset::where('asset_tag', 'IT-TEST')->delete();

        $import->model([
            'asset_tag'       => 'IT-TEST',
            'nombre'          => 'Test',
            'categoria'       => 'Hardware',
            'estado'          => $input,
            'fecha_de_compra' => '',
            'proveedor'       => '',
            'ubicacion'       => '',
            'costo'           => '',
            'marca'           => '',
            'modelo'          => '',
            'numero_de_serie' => '',
        ]);

        expect(Asset::where('asset_tag', 'IT-TEST')->first()->status)->toBe($expected);
    }
});
