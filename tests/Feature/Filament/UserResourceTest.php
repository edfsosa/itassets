<?php

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    loginAsAdmin();
});

it('lists users', function () {
    User::factory()->count(3)->create();

    $this->get('/admin/users')->assertOk();
});

it('creates a user with a hashed password', function () {
    $viewerRoleId = Role::where('name', 'Viewer')->value('id');

    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'New User',
            'email' => 'new.user@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'roles' => [$viewerRoleId],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $user = User::where('email', 'new.user@example.com')->first();
    expect($user)->not->toBeNull()
        ->and(Hash::check('password123', $user->password))->toBeTrue();
});

it('rejects a duplicate email', function () {
    User::factory()->create(['email' => 'dup@example.com']);
    $viewerRoleId = Role::where('name', 'Viewer')->value('id');

    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'Dup',
            'email' => 'dup@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'roles' => [$viewerRoleId],
        ])
        ->call('create')
        ->assertHasFormErrors(['email' => 'unique']);
});

it('requires at least one role', function () {
    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'No Role',
            'email' => 'norole@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'roles' => [],
        ])
        ->call('create')
        ->assertHasFormErrors(['roles' => 'required']);
});

it('keeps the existing password when left blank on edit', function () {
    $user = User::factory()->viewer()->create();
    $originalHash = $user->password;

    Livewire::test(EditUser::class, ['record' => $user->getRouteKey()])
        ->fillForm([
            'name' => $user->name,
            'email' => $user->email,
            'password' => '',
            'password_confirmation' => '',
            'roles' => $user->roles->pluck('id')->all(),
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($user->fresh()->password)->toBe($originalHash);
});

it('prevents an admin from deactivating their own account', function () {
    $admin = auth()->user();

    Livewire::test(EditUser::class, ['record' => $admin->getRouteKey()])
        ->callAction('toggleActive');

    expect($admin->fresh()->is_active)->toBeTrue();
});

it('prevents an admin from removing their own Admin role', function () {
    $admin = auth()->user();
    $viewerRoleId = Role::where('name', 'Viewer')->value('id');

    Livewire::test(EditUser::class, ['record' => $admin->getRouteKey()])
        ->fillForm([
            'name' => $admin->name,
            'email' => $admin->email,
            'roles' => [$viewerRoleId],
        ])
        ->call('save');

    expect($admin->fresh()->hasRole('Admin'))->toBeTrue();
});

it('prevents demoting the last admin away from the Admin role', function () {
    loginAsEditor();
    $onlyAdmin = User::factory()->admin()->create();
    $viewerRoleId = Role::where('name', 'Viewer')->value('id');

    Livewire::test(EditUser::class, ['record' => $onlyAdmin->getRouteKey()])
        ->fillForm([
            'name' => $onlyAdmin->name,
            'email' => $onlyAdmin->email,
            'roles' => [$viewerRoleId],
        ])
        ->call('save');

    expect($onlyAdmin->fresh()->hasRole('Admin'))->toBeTrue();
});

it('prevents an editor from granting the Admin role to another user', function () {
    loginAsEditor();
    $adminRoleId = Role::where('name', 'Admin')->value('id');
    $viewerRoleId = Role::where('name', 'Viewer')->value('id');
    $target = User::factory()->viewer()->create();

    Livewire::test(EditUser::class, ['record' => $target->getRouteKey()])
        ->fillForm([
            'name' => $target->name,
            'email' => $target->email,
            'roles' => [$viewerRoleId, $adminRoleId],
        ])
        ->call('save');

    expect($target->fresh()->hasRole('Admin'))->toBeFalse();
});

it('allows deactivating a user who is not the last active admin', function () {
    $otherAdmin = User::factory()->admin()->create();

    Livewire::test(EditUser::class, ['record' => $otherAdmin->getRouteKey()])
        ->callAction('toggleActive');

    expect($otherAdmin->fresh()->is_active)->toBeFalse();
});

it('records the last login time when a user logs in', function () {
    $user = User::factory()->viewer()->create(['last_login_at' => null]);

    event(new Login('web', $user, false));

    expect($user->fresh()->last_login_at)->not->toBeNull();
});

it('returns 404 for a non-existent user', function () {
    $this->get('/admin/users/99999')->assertNotFound();
});

it('denies viewer from creating a user', function () {
    loginAsViewer();

    Livewire::test(CreateUser::class)->assertForbidden();
});

it('hides the toggleActive action from editor on the edit page', function () {
    $user = User::factory()->create();
    loginAsEditor();

    Livewire::test(EditUser::class, ['record' => $user->getRouteKey()])
        ->assertActionHidden('toggleActive');
});

it('hides the deactivate bulk action from editor on the list page', function () {
    User::factory()->create();
    loginAsEditor();

    Livewire::test(ListUsers::class)->assertTableBulkActionHidden('deactivate');
});
