---
title: Badges & Visibility
description: Add badges to navigation and show or hide items conditionally.
order: 2
---

# Badges & Visibility

## Static Badge

```php
use Laravilt\Panel\Resources\Resource;

class OrderResource extends Resource
{
    protected static ?string $navigationBadge = 'New';

    protected static ?string $navigationBadgeColor = 'info';
}
```

## Dynamic Badge

```php
class OrderResource extends Resource
{
    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'pending')->count();

        return $count > 0 ? (string) $count : null;
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

## Badges on Custom Items

```php
NavigationItem::make('Inbox')
    ->url('/admin/inbox')
    ->badge(fn () => auth()->user()->unreadMessages()->count(), 'danger');
```

## Conditional Navigation

### Resources

A resource is shown when `$navigationVisible` is true and `canAccess()` passes. Override `isNavigationVisible()` for custom logic:

```php
public static function isNavigationVisible(): bool
{
    return auth()->user()?->can('view_users') ?? false;
}
```

### Pages and Clusters

```php
public static function shouldRegisterNavigation(): bool
{
    return auth()->user()?->isAdmin() ?? false;
}
```

### Custom Navigation

```php
$panel->navigation(function (NavigationBuilder $builder) {
    if (auth()->user()?->isAdmin()) {
        $builder->item(
            NavigationItem::make('Admin Tools')
                ->icon('Wrench')
                ->url('/admin/tools')
        );
    }
});
```
