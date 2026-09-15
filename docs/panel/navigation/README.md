---
title: Navigation
description: How the panel sidebar is built from resources, pages and clusters.
order: 9
---

# Navigation

The sidebar is built automatically from the panel's registered resources, pages and clusters, and grouped by `$navigationGroup`. You can also replace it entirely with [custom items](items.md).

## Navigation in Resources

```php
use Laravilt\Panel\Resources\Resource;

class UserResource extends Resource
{
    protected static ?string $navigationIcon = 'Users';

    protected static ?string $navigationGroup = 'User Management';

    protected static int $navigationSort = 1;

    protected static ?string $pluralLabel = 'Users';   // Used as the navigation label
}
```

Override `getNavigationLabel()` for a label different from the plural label.

## Navigation in Pages

```php
use Laravilt\Panel\Pages\Page;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'Settings';

    protected static ?string $navigationLabel = 'Settings';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 100;
}
```

Icons are [Lucide](https://lucide.dev/icons) icon names.

## Hiding from Navigation

```php
// Resource
protected static bool $navigationVisible = false;

// Page
protected static bool $shouldRegisterNavigation = false;
```

## In this section

1. [Navigation Items](items.md): custom items and groups
2. [Badges & Visibility](badges.md): badges and conditional navigation
3. [Clusters](clusters.md): group pages under one navigation item
