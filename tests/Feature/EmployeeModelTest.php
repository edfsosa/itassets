<?php

use App\Models\Employee;

beforeEach(function () {
    loginAsAdmin();
});

it('has active scope', function () {
    Employee::factory()->count(3)->create();
    Employee::factory()->inactive()->count(2)->create();

    expect(Employee::where('is_active', true)->count())->toBe(3);
});

it('casts is_active to boolean and defaults to true', function () {
    $employee = Employee::factory()->create();

    expect($employee->is_active)->toBeTrue();
});

it('has assignments relationship', function () {
    $employee = Employee::factory()->create();

    expect($employee->assignments)->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class);
});

it('has activeAssignments scope', function () {
    $employee = Employee::factory()->create();

    expect($employee->activeAssignments())->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\HasMany::class);
});

