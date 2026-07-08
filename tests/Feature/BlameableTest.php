<?php

use App\Models\Asset;
use App\Models\User;

beforeEach(function () {
    loginAsAdmin();
});

it('sets created_by when creating a model', function () {
    $asset = Asset::factory()->create();

    expect($asset->created_by)->toBe(auth()->id());
});

it('sets updated_by when creating a model', function () {
    $asset = Asset::factory()->create();

    expect($asset->updated_by)->toBe(auth()->id());
});

it('updates updated_by when updating a model', function () {
    $asset = Asset::factory()->create();
    $anotherUser = User::factory()->create();

    $this->actingAs($anotherUser);
    $asset->update(['name' => 'Updated Name']);

    expect($asset->fresh()->updated_by)->toBe($anotherUser->id);
});

it('does not set blameable when no user is logged in', function () {
    auth()->logout();

    $asset = Asset::factory()->create();

    expect($asset->created_by)->toBeNull();
    expect($asset->updated_by)->toBeNull();
});

it('has creator and updater relationships', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $asset = Asset::factory()->create();

    expect($asset->creator)->toBeInstanceOf(User::class);
    expect($asset->creator->id)->toBe($user->id);
    expect($asset->updater)->toBeInstanceOf(User::class);
    expect($asset->updater->id)->toBe($user->id);
});
