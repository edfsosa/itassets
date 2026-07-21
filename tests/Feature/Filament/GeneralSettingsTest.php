<?php

use App\Filament\Pages\GeneralSettings;
use App\Models\Setting;
use Livewire\Livewire;

beforeEach(function () {
    loginAsAdmin();
});

it('saves all five regional settings', function () {
    Livewire::test(GeneralSettings::class)
        ->fillForm([
            'base_currency' => 'PYG',
            'display_currency' => 'USD',
            'exchange_rate' => 6500,
            'display_locale' => 'es_PY',
            'timezone' => 'America/Asuncion',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect(Setting::get('base_currency'))->toBe('PYG');
    expect(Setting::get('display_currency'))->toBe('USD');
    expect((float) Setting::get('exchange_rate'))->toBe(6500.0);
    expect(Setting::get('display_locale'))->toBe('es_PY');
    expect(Setting::get('timezone'))->toBe('America/Asuncion');
});
