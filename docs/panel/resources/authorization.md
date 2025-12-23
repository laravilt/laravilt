---
title: Resource Authorization
description: Control access to resource actions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: resources
---

# Resource Authorization

Control access to resource actions with authorization methods.

## Basic Authorization

```php
<?php

namespace App\Laravilt\Admin\Resources\User;

use App\Models\User;
use Laravilt\Panel\Resources\Resource;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_any_user');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create_user');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('update', $record);
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete', $record);
    }
}
```

## Hide from Navigation

```php
<?php

namespace App\Laravilt\Admin\Resources\Internal;

use Laravilt\Panel\Resources\Resource;

class InternalResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;
}
```

## Conditional Navigation

```php
<?php

namespace App\Laravilt\Admin\Resources\Admin;

use Laravilt\Panel\Resources\Resource;

class AdminResource extends Resource
{
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('view_admin_resources');
    }
}
```

## API Reference

| Property | Type | Description |
|----------|------|-------------|
| `$model` | `string` | Eloquent model class |
| `$navigationIcon` | `string` | Lucide icon |
| `$navigationGroup` | `string` | Navigation group |
| `$navigationSort` | `int` | Sort order |
| `$navigationLabel` | `string` | Custom label |
| `$recordTitleAttribute` | `string` | Title column |
| `$slug` | `string` | URL slug |
| `$hasSoftDeletes` | `bool` | Soft delete support |
