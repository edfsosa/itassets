<?php

use App\Models\User;

beforeEach(function () {
    createRolesAndPermissions();
    $this->admin = User::factory()->admin()->create();
    $this->actingAs($this->admin);
});

it('lists users', function () {
    User::factory()->count(3)->create();

    $this->get('/admin/users')->assertOk();
});

it('can render create user page', function () {
    $this->get('/admin/users/create')->assertOk();
});

it('can render edit user page', function () {
    $user = User::factory()->create();

    $this->get("/admin/users/{$user->id}/edit")->assertOk();
});

it('can render view user page', function () {
    $user = User::factory()->create();

    $this->get("/admin/users/{$user->id}")->assertOk();
});
