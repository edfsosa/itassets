<?php

use App\Models\Asset;
use App\Models\User;

beforeEach(function () {
    createRolesAndPermissions();
    $this->admin = User::factory()->admin()->create();
    $this->actingAs($this->admin);
});

it('lists assets', function () {
    Asset::factory()->count(3)->create();

    $this->get('/admin/assets')->assertOk();
});

it('can render create page', function () {
    $this->get('/admin/assets/create')->assertOk();
});

it('can render edit page', function () {
    $asset = Asset::factory()->create();

    $this->get("/admin/assets/{$asset->id}/edit")->assertOk();
});

it('can render view page', function () {
    $asset = Asset::factory()->create();

    $this->get("/admin/assets/{$asset->id}")->assertOk();
});

it('returns 404 for non-existent asset', function () {
    $this->get('/admin/assets/99999')->assertNotFound();
});
