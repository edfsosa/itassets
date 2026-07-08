<?php

use App\Models\Assignment;
use App\Models\Asset;
use App\Models\Employee;

beforeEach(function () {
    loginAsAdmin();
});

it('has active scope', function () {
    Assignment::factory()->count(2)->create();
    Assignment::factory()->returned()->create();

    expect(Assignment::active()->count())->toBe(2);
});

it('has returned scope', function () {
    Assignment::factory()->count(2)->create();
    Assignment::factory()->returned()->count(3)->create();

    expect(Assignment::returned()->count())->toBe(3);
});

it('belongs to an employee', function () {
    $employee = Employee::factory()->create();
    $assignment = Assignment::factory()->create(['employee_id' => $employee->id]);

    expect($assignment->employee)->toBeInstanceOf(Employee::class);
    expect($assignment->employee->id)->toBe($employee->id);
});

it('can attach assets', function () {
    $assignment = Assignment::factory()->create();
    $assets = Asset::factory()->count(2)->create();

    $assignment->assets()->attach($assets->pluck('id')->toArray(), [
        'assigned_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    expect($assignment->assets()->count())->toBe(2);
});

it('marks assets as available when returned', function () {
    $asset = Asset::factory()->available()->create();
    $assignment = Assignment::factory()->create();

    $assignment->assets()->attach($asset->id, [
        'assigned_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    expect($asset->fresh()->status)->toBe('assigned');

    $assignment->update(['returned_at' => now()]);
    expect($asset->fresh()->status)->toBe('available');
});
