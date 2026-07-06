<?php

namespace App\Filament\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait HasResourcePermissions
{
    abstract protected static function getPermissionName(): string;

    public static function canViewAny(): bool
    {
        return Auth::user()?->can('view_any_' . static::getPermissionName()) ?? false;
    }

    public static function canView(Model $record): bool
    {
        return Auth::user()?->can('view_' . static::getPermissionName()) ?? false;
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('create_' . static::getPermissionName()) ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()?->can('update_' . static::getPermissionName()) ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()?->can('delete_' . static::getPermissionName()) ?? false;
    }
}
