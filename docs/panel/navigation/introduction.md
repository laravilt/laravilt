---
title: Navigation
description: Configure sidebar navigation in your panel
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: navigation
---

# Navigation

Navigation configuration controls the sidebar menu structure in your Laravilt panel.

## Auto-Discovery

By default, resources and pages are automatically discovered:

```php
use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->discoverResources(in: app_path('Laravilt/Admin/Resources'))
            ->discoverPages(in: app_path('Laravilt/Admin/Pages'));
    }
}
```

## Navigation in Resources

```php
use Laravilt\Panel\Resources\Resource;

class UserResource extends Resource
{
    protected static ?string $navigationIcon = 'Users';
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 1;
}
```

## Navigation in Pages

```php
use Laravilt\Panel\Pages\Page;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'Settings';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 100;
}
```

## Hide from Navigation

```php
use Laravilt\Panel\Resources\Resource;

class InternalResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;
}
```

## Related

- [Items](items) - Custom navigation items
- [Badges](badges) - Badges and conditional navigation
- [Clusters](clusters) - Group pages under navigation items
