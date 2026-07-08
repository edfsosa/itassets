<?php

use App\Models\Setting;

beforeEach(function () {
    Setting::set('exchange_rate_usd_pyg', 6500);
});

it('formats zero amount', function () {
    expect(format_gs(0))->toBe('Gs. 0');
});

it('formats integer amount', function () {
    expect(format_gs(1))->toBe('Gs. 6.500');
});

it('formats large amount', function () {
    expect(format_gs(1000))->toBe('Gs. 6.500.000');
});

it('formats decimal amount', function () {
    expect(format_gs(99.99))->toBe('Gs. 649.935');
});

it('returns dash for null amount', function () {
    expect(format_gs(null))->toBe('—');
});

it('uses custom exchange rate from settings', function () {
    Setting::set('exchange_rate_usd_pyg', 7000);

    expect(format_gs(1))->toBe('Gs. 7.000');
});
