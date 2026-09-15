---
title: Resource Authorization
description: Control who can list, view, create, update and delete a resource's records.
order: 3
---

# Resource Authorization

Every resource has static authorization methods. By default they check permissions (via `spatie/laravel-permission`, as set up by the Users package) named `{action}_{model}` in snake case. For example: `view_any_user`, `view_user`, `create_user`, `update_user`, `delete_user`.

## Available Checks

| Method | Default permission |
|--------|--------------------|
| `canViewAny()` | `view_any_{model}` |
| `canView(?Model $record)` | `view_{model}` |
| `canCreate()` | `create_{model}` |
| `canUpdate(?Model $record)` | `update_{model}` |
| `canDelete(?Model $record)` | `delete_{model}` |
| `canRestore(?Model $record)` | `restore_{model}` |
| `canForceDelete(?Model $record)` | `force_delete_{model}` |
| `canReplicate(?Model $record)` | `replicate_{model}` |
| `canReorder()` | `reorder_{model}` |
| `canAccess()` | Access to the resource at all |

The separator, case and super-admin bypass are set in the Users package config (`laravilt-users.permissions.*`, `laravilt-users.super_admin.*`).

## Custom Authorization

Override any of the methods:

```php
<?php

namespace App\Laravilt\Admin\Resources\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Laravilt\Panel\Resources\Resource;

class UserResource extends Resource
{
    protected static string $model = User::class;

    public static function canViewAny(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function canUpdate(?Model $record = null): bool
    {
        return auth()->user()->can('update', $record);
    }

    public static function canDelete(?Model $record = null): bool
    {
        return $record?->isNot(auth()->user()) ?? false;
    }
}
```

## Hiding from Navigation

A resource appears in the sidebar when `$navigationVisible` is true and `canAccess()` passes:

```php
class InternalResource extends Resource
{
    protected static bool $navigationVisible = false;
}
```

For conditional visibility, override `isNavigationVisible()`:

```php
public static function isNavigationVisible(): bool
{
    return auth()->user()?->can('view_admin_resources') ?? false;
}
```

## Related

- [Navigation](../navigation/README.md)
