<?php

use App\Models\Employee;

beforeEach(function () {
    loginAsAdmin();
});

it('has active scope', function () {
    Employee::factory()->count(3)->create();
    Employee::factory()->inactive()->count(2)->create();

    expect(Employee::where('status', 'active')->count())->toBe(3);
});

it('has correct status label', function () {
    $employee = Employee::factory()->create(['status' => 'active']);

    expect($employee->getStatusLabel())->toBe('Activo');
});

it('has assignments relationship', function () {
    $employee = Employee::factory()->create();

    expect($employee->assignments)->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class);
});

it('has activeAssignments scope', function () {
    $employee = Employee::factory()->create();

    expect($employee->activeAssignments())->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\HasMany::class);
});

it('has status constants defined', function () {
    expect(Employee::STATUSES)->toHaveKeys(['active', 'inactive']);
});
