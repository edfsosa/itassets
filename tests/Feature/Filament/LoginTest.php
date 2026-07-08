<?php

use App\Models\User;

beforeEach(function () {
    createRolesAndPermissions();
});

it('redirects unauthenticated users to login', function () {
    $this->get('/admin')->assertRedirect('/admin/login');
});

it('allows admin to access filament panel', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->get('/admin')
        ->assertOk();
});

it('allows viewer to access filament panel', function () {
    $user = User::factory()->viewer()->create();

    $this->actingAs($user)
        ->get('/admin')
        ->assertOk();
});

it('allows editor to access filament panel', function () {
    $user = User::factory()->editor()->create();

    $this->actingAs($user)
        ->get('/admin')
        ->assertOk();
});
