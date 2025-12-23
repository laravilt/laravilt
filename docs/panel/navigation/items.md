---
title: Navigation Items
description: Create custom navigation items and groups
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: navigation
---

# Navigation Items

Create custom navigation items in your panel configuration.

## Custom Items

```php
use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;
use Laravilt\Panel\Navigation\NavigationBuilder;
use Laravilt\Panel\Navigation\NavigationGroup;
use Laravilt\Panel\Navigation\NavigationItem;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel->navigation(function (NavigationBuilder $builder): NavigationBuilder {
            return $builder
                ->groups([
                    NavigationGroup::make('Dashboard')
                        ->items([
                            NavigationItem::make('Dashboard')
                                ->icon('LayoutDashboard')
                                ->url('/admin')
                                ->isActiveWhen(fn () => request()->routeIs('admin.dashboard')),
                        ]),
                ])
                ->items([
                    NavigationItem::make('External Link')
                        ->icon('ExternalLink')
                        ->url('https://example.com')
                        ->openUrlInNewTab(),
                ]);
        });
    }
}
```

## Navigation Groups

```php
use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;
use Laravilt\Panel\Navigation\NavigationGroup;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel->navigationGroups([
            NavigationGroup::make('Reports')
                ->collapsible()
                ->collapsed(),
        ]);
    }
}
```

## Nested Navigation

```php
use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;
use Laravilt\Panel\Navigation\NavigationGroup;
use Laravilt\Panel\Navigation\NavigationItem;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel->navigationGroups([
            NavigationGroup::make('Settings')
                ->items([
                    NavigationItem::make('General')
                        ->icon('Settings')
                        ->url('/admin/settings/general'),
                    NavigationItem::make('Email')
                        ->icon('Mail')
                        ->url('/admin/settings/email'),
                ]),
        ]);
    }
}
```

## API Reference

### NavigationGroup

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `string $label` | Create group |
| `icon()` | `string` | Group icon |
| `items()` | `array` | Navigation items |
| `collapsible()` | `bool` | Enable collapse |
| `collapsed()` | `bool` | Start collapsed |

### NavigationItem

| Method | Parameters | Description |
|--------|-----------|-------------|
| `make()` | `string $label` | Create item |
| `icon()` | `string` | Item icon |
| `url()` | `string\|Closure` | Item URL |
| `isActiveWhen()` | `Closure` | Active condition |
| `openUrlInNewTab()` | — | Open in new tab |
| `visible()` | `bool\|Closure` | Visibility |
