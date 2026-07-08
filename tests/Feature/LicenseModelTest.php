<?php

use App\Models\License;
use App\Models\LicenseAssignment;

beforeEach(function () {
    loginAsAdmin();
});

it('computes used seats correctly', function () {
    $license = License::factory()->create(['total_seats' => 10]);
    LicenseAssignment::factory()->count(3)->create(['license_id' => $license->id]);

    expect($license->usedSeats())->toBe(3);
});

it('computes available seats correctly', function () {
    $license = License::factory()->create(['total_seats' => 10]);
    LicenseAssignment::factory()->count(3)->create(['license_id' => $license->id]);

    expect($license->availableSeats())->toBe(7);
});

it('has available seats when none assigned', function () {
    $license = License::factory()->create(['total_seats' => 5]);
    LicenseAssignment::factory()->create(['license_id' => $license->id, 'released_at' => now()]);

    expect($license->availableSeats())->toBe(5);
});

it('has no available seats when fully assigned', function () {
    $license = License::factory()->create(['total_seats' => 2]);
    LicenseAssignment::factory()->count(2)->create(['license_id' => $license->id]);

    expect($license->hasAvailableSeats())->toBeFalse();
});

it('has available seats when not fully assigned', function () {
    $license = License::factory()->create(['total_seats' => 5]);
    LicenseAssignment::factory()->count(3)->create(['license_id' => $license->id]);

    expect($license->hasAvailableSeats())->toBeTrue();
});

it('has license types defined', function () {
    expect(License::TYPES)->toHaveKeys(['perpetual', 'subscription', 'per_device', 'per_user', 'concurrent']);
});
