---
title: Creating Panels
description: Generate a new admin panel with the laravilt:panel command.
order: 1
---

# Creating Panels

`php artisan laravilt:install` creates your first panel. To add more panels later, use `laravilt:panel`.

## Using the Artisan Command

```bash
php artisan laravilt:panel admin
```

The command asks which features to enable (login, registration, password reset, email verification, OTP, magic links, profile, two-factor, passkeys, social login, connected accounts, session management, API tokens, database notifications, locale & timezone, global search, AI providers). If you pick two-factor or social login, it then asks which providers to use.

### Command Options

```bash
# Serve the panel at /dashboard instead of /admin
php artisan laravilt:panel admin --path=dashboard

# Skip the prompts and use the default feature set
php artisan laravilt:panel admin --quick
```

| Argument / option | Description |
|-------------------|-------------|
| `id` | Panel identifier (prompted if omitted) |
| `--path=` | URL path for the panel (defaults to the id) |
| `--quick` | Non-interactive mode with default features |

## What Gets Created

For `php artisan laravilt:panel admin` the command:

- writes `app/Providers/Laravilt/AdminPanelProvider.php`
- creates `app/Laravilt/Admin/{Pages,Resources,Widgets}`
- creates the dashboard page `app/Laravilt/Admin/Pages/Dashboard.php`
- registers the provider in `bootstrap/providers.php`

The generated provider looks like this (the auth methods depend on the features you selected):

```php
namespace App\Providers\Laravilt;

use Laravilt\Panel\Panel;
use Laravilt\Panel\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->brandName('Admin')
            ->discoverAutomatically()
            ->login()
            ->registration()
            ->passwordReset()
            ->profile();
    }
}
```

## Creating a Panel Manually

Any class extending `Laravilt\Panel\PanelProvider` works. Register it in `bootstrap/providers.php`:

```php
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Laravilt\AdminPanelProvider::class,
];
```

## Basic Settings

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')                     // Unique identifier
        ->path('admin')                   // URL prefix
        ->default()                       // Mark as the default panel
        ->middleware(['web'])             // Panel middleware (default: ['web'])
        ->authMiddleware(['panel.auth'])  // Middleware for authenticated routes
        ->authGuard('web')                // Auth guard
        ->maxContentWidth('7xl');
}
```

## Next Steps

- [Panel Provider](panel-provider.md): provider, facade and config
- [Discovery](discovery.md): register resources, pages and widgets
- [Panel Authentication](panel-auth.md): auth features
