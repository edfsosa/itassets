<?php

use App\Models\Asset;
use App\Notifications\WarrantyExpiryNotification;
use App\Models\User;

it('has correct structure for expiring warranty', function () {
    $asset = Asset::factory()->create([
        'asset_tag' => 'IT-0001',
        'name' => 'Test Asset',
        'warranty_expiry_date' => now()->addDays(30),
    ]);

    $notification = new WarrantyExpiryNotification($asset, 30);
    $array = $notification->toArray(new User);

    expect($array['asset_id'])->toBe($asset->id);
    expect($array['asset_tag'])->toBe('IT-0001');
    expect($array['asset_name'])->toBe('Test Asset');
    expect($array['days_remaining'])->toBe(30);
    expect($array['type'])->toBe('warranty_expiring');
    expect($array['message'])->toContain('Garantía por vencer');
});

it('has correct structure for expired warranty', function () {
    $asset = Asset::factory()->create([
        'asset_tag' => 'IT-0002',
        'name' => 'Old Asset',
        'warranty_expiry_date' => now()->subDays(5),
    ]);

    $notification = new WarrantyExpiryNotification($asset, -5);
    $array = $notification->toArray(new User);

    expect($array['days_remaining'])->toBe(-5);
    expect($array['type'])->toBe('warranty_expired');
    expect($array['message'])->toContain('Garantía vencida');
});
