---
title: Navigation Items
description: Build a custom sidebar with navigation items and groups.
order: 1
---

# Navigation Items

Pass a callback to `navigation()` to build the sidebar yourself. When a callback is set, it **replaces** the auto-generated navigation, so include every link you want to show.

## Custom Navigation

```php
use Laravilt\Panel\Navigation\NavigationBuilder;
use Laravilt\Panel\Navigation\NavigationItem;
use Laravilt\Panel\Panel;

public function panel(Panel $panel): Panel
{
    return $panel->navigation(function (NavigationBuilder $builder) {
        $builder
            ->items([
                NavigationItem::make('Dashboard')
                    ->icon('LayoutDashboard')
                    ->url('/admin')
                    ->sort(0),
            ])
            ->group('Settings', [
                NavigationItem::make('General')
                    ->icon('Settings')
                    ->url('/admin/settings/general'),
                NavigationItem::make('Email')
                    ->icon('Mail')
                    ->url('/admin/settings/email'),
            ]);
    });
}
```

## Navigation Groups

`$builder->group()` creates a `NavigationGroup`. You can also build groups yourself:

```php
use Laravilt\Panel\Navigation\NavigationGroup;

NavigationGroup::make('Reports')
    ->icon('BarChart3')
    ->collapsible()
    ->collapsed()
    ->items([
        NavigationItem::make('Sales')->url('/admin/reports/sales'),
    ]);
```

## API Reference

### NavigationBuilder

| Method | Description |
|--------|-------------|
| `item(NavigationItem\|string)` | Add one item |
| `items(array)` | Add several items |
| `group(string $label, array\|Closure $items)` | Add a group |

### NavigationGroup

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `string\|Closure $label` | Create group |
| `icon()` | `?string` | Group icon |
| `items()` | `array` | Navigation items |
| `sort()` | `?int` | Sort order |
| `collapsible()` | `bool\|Closure = true` | Allow collapsing |
| `collapsed()` | `bool\|Closure = true` | Start collapsed |

### NavigationItem

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `string\|Closure $label` | Create item |
| `icon()` | `?string` | Lucide icon |
| `url()` | `string\|Closure\|null` | Target URL |
| `badge()` | `string\|int\|Closure, ?string $color` | Badge and color |
| `sort()` | `int\|Closure` | Sort order |
| `active()` | `bool\|Closure = true` | Mark as active |
| `activeMatchPrefix()` | `?string` | Active when the URL starts with this prefix |
| `method()` | `?string` | HTTP method (e.g. `post` for logout-style links) |
| `translationKey()` | `string` | Translation key for the label |
