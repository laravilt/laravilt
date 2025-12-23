---
title: Pages
description: Custom standalone pages in your panel
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: panel
concept: pages
---

# Pages

Pages are standalone views in your panel that don't belong to a specific resource.

## Creating a Page

```bash
php artisan laravilt:page Dashboard
php artisan laravilt:page Settings
```

## Basic Page

```php
<?php

namespace App\Laravilt\Admin\Pages;

use Laravilt\Panel\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'LayoutDashboard';
    protected static ?string $title = 'Dashboard';
    protected static ?string $slug = 'dashboard';
    protected static ?int $navigationSort = -2;

    public function getView(): string
    {
        return 'laravilt.pages.dashboard';
    }
}
```

## Navigation Properties

```php
use Laravilt\Panel\Pages\Page;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'Settings';
    protected static ?string $navigationLabel = 'Site Settings';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 100;
}
```

## Navigation Badge

```php
use Laravilt\Panel\Pages\Page;

class Notifications extends Page
{
    public static function getNavigationBadge(): ?string
    {
        return 'New';
    }
}
```

## Hide from Navigation

```php
use Laravilt\Panel\Pages\Page;

class HiddenPage extends Page
{
    protected static bool $shouldRegisterNavigation = false;
}
```

## Authorization

```php
use Laravilt\Panel\Pages\Page;

class AdminSettings extends Page
{
    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin();
    }
}
```

## Middleware

```php
use Laravilt\Panel\Pages\Page;

class VerifiedPage extends Page
{
    protected static string | array $middleware = ['verified'];
}
```

## Related

- [Forms](forms) - Pages with forms
- [Widgets](widgets) - Pages with widgets
- [Tables](tables) - Pages with tables
- [Infolist](infolist) - Pages with infolists
