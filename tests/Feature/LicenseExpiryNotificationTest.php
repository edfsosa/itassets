<?php

use App\Models\License;
use App\Notifications\LicenseExpiryNotification;
use App\Models\User;

it('has correct structure for expiring license', function () {
    $license = License::factory()->create([
        'product_name' => 'Microsoft 365',
        'expiry_date' => now()->addDays(30),
    ]);

    $notification = new LicenseExpiryNotification($license, 30);
    $array = $notification->toArray(new User);

    expect($array['license_id'])->toBe($license->id);
    expect($array['product_name'])->toBe('Microsoft 365');
    expect($array['days_remaining'])->toBe(30);
    expect($array['type'])->toBe('license_expiring');
    expect($array['message'])->toContain('Licencia por vencer');
});

it('has correct structure for expired license', function () {
    $license = License::factory()->create([
        'product_name' => 'Adobe CC',
        'expiry_date' => now()->subDays(10),
    ]);

    $notification = new LicenseExpiryNotification($license, -10);
    $array = $notification->toArray(new User);

    expect($array['days_remaining'])->toBe(-10);
    expect($array['type'])->toBe('license_expired');
    expect($array['message'])->toContain('Licencia vencida');
});
