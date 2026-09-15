---
title: Pages
description: Custom standalone pages in your panel.
order: 8
---

# Pages

Pages are standalone screens in your panel that don't belong to a resource: settings, reports, dashboards and so on. Each page is a PHP class extending `Laravilt\Panel\Pages\Page`, rendered through Inertia.

## Creating a Page

```bash
php artisan laravilt:page
php artisan laravilt:page Admin Settings --type=basic
```

| Argument / option | Description |
|-------------------|-------------|
| `panel` | Target panel (prompted if omitted) |
| `name` | Page class name (prompted if omitted) |
| `--type=` | `basic`, `form`, `table` or `dashboard` |

The command also asks which extras to add (header actions, footer actions, widgets, breadcrumbs, polling). It creates:

- `app/Laravilt/Admin/Pages/Settings.php`
- `resources/js/pages/Admin/Settings.vue` for the Vue stack, or `resources/js/pages/Admin/Settings.tsx` for the React stack

> React support requires Laravilt v1.1 or later.

## Basic Page

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Page;

class Reports extends Page
{
    protected static ?string $navigationIcon = 'BarChart3';

    protected static ?string $title = 'Reports';

    protected static ?string $slug = 'reports';

    protected static ?int $navigationSort = 10;
}
```

By default a page renders the built-in `laravilt/Page` component. It shows the page heading, header actions, widgets and the components returned by `getSchema()`. To render your own frontend page instead, set `$view` to its Inertia component name:

```php
protected static string $view = 'Admin/Reports';   // resources/js/pages/Admin/Reports.vue or .tsx
```

## Navigation Properties

```php
class Settings extends Page
{
    protected static ?string $navigationIcon = 'Settings';
    protected static ?string $navigationLabel = 'Site Settings';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 100;
    protected static bool $shouldRegisterNavigation = true;
    protected static ?string $cluster = null;   // See Clusters
}
```

## Authorization

The base page runs `authorizeAccess()` before rendering. Override it to restrict access:

```php
protected function authorizeAccess(): void
{
    abort_unless(auth()->user()?->isAdmin(), 403);
}
```

To hide a page from the sidebar based on permissions, add the `HasPageAuthorization` trait. It checks a `view_{page_name}` permission, or the one you set in `$permission`:

```php
use Laravilt\Panel\Concerns\HasPageAuthorization;

class Settings extends Page
{
    use HasPageAuthorization;

    protected static ?string $permission = 'manage_settings';
}
```

## Page API

| Member | Description |
|--------|-------------|
| `$title`, `$slug`, `$view` | Title, URL segment, Inertia component |
| `getHeading()`, `getSubheading()` | Header text |
| `getSchema()` | Form fields, sections or infolist entries to render |
| `getHeaderActions()` | Actions in the page header |
| `getWidgets()` | Widgets shown above the content |
| `getBreadcrumbs()` | Breadcrumb trail |
| `getLayout()` | Layout (`PageLayout` enum value) |
| `topHook()` / `bottomHook()` | Extra content above/below the form |

## In this section

1. [Page Forms](forms.md): settings and data-entry pages
2. [Page Tables](tables.md): data listings
3. [Page Infolists](infolist.md): read-only displays
4. [Page Widgets & Actions](widgets.md): widgets, header actions, subheadings, breadcrumbs
