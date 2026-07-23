<?php

namespace App\Filament\Concerns;

use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait HasRelationManagerPermissions
{
    abstract protected function getPermissionName(): string;

    protected function authorizeAbility(string $ability): Response
    {
        return Auth::user()?->can($ability)
            ? Response::allow()
            : Response::deny();
    }

    // Same rationale as HasResourcePermissions, but RelationManager authorizes
    // via instance methods (InteractsWithRelationshipTable), not static ones.
    protected function getCreateAuthorizationResponse(): Response
    {
        return $this->authorizeAbility('create_' . $this->getPermissionName());
    }

    protected function getEditAuthorizationResponse(Model $record): Response
    {
        return $this->authorizeAbility('update_' . $this->getPermissionName());
    }

    protected function getDeleteAuthorizationResponse(Model $record): Response
    {
        return $this->authorizeAbility('delete_' . $this->getPermissionName());
    }

    protected function getDeleteAnyAuthorizationResponse(): Response
    {
        return $this->authorizeAbility('delete_' . $this->getPermissionName());
    }
}
