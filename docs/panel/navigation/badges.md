---
title: Navigation Badges
description: Add badges and conditional visibility to navigation
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: navigation
---

# Navigation Badges

Add dynamic badges and conditional visibility to navigation items.

## Static Badge

```php
use Laravilt\Panel\Resources\Resource;

class OrderResource extends Resource
{
    public static function getNavigationBadge(): ?string
    {
        return 'New';
    }
}
```

## Dynamic Badge

```php
use Laravilt\Panel\Resources\Resource;

class OrderResource extends Resource
{
    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('status', 'pending')->count();
    }
}
```

## Badge Color

```php
use Laravilt\Panel\Resources\Resource;

class OrderResource extends Resource
{
    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::where('status', 'pending')->count();

        return match (true) {
            $count > 10 => 'danger',
            $count > 5 => 'warning',
            default => 'success',
        };
    }
}
```

## Conditional Navigation

### Hide Based on Permission

```php
use Laravilt\Panel\Resources\Resource;

class UserResource extends Resource
{
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('view_users');
    }
}
```

### Dynamic Navigation

```php
use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;
use Laravilt\Panel\Navigation\NavigationBuilder;
use Laravilt\Panel\Navigation\NavigationItem;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel->navigation(function (NavigationBuilder $builder): NavigationBuilder {
            $items = [...];

            if (auth()->user()->isAdmin()) {
                $items[] = NavigationItem::make('Admin Tools')
                    ->icon('Wrench')
                    ->url('/admin/tools');
            }

            return $builder->items($items);
        });
    }
}
```
