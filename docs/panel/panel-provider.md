---
title: Panel Provider
description: Configure a panel through its provider, the Panel facade and the published config.
order: 2
---

# Panel Provider

Each panel is configured by a provider class that extends `Laravilt\Panel\PanelProvider` and implements `panel()`.

## Basic Configuration

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
            ->brandName('My Admin')
            ->colors(['primary' => '#3b82f6'])
            ->discoverAutomatically()
            ->login()
            ->registration();
    }
}
```

## Common Methods

| Group | Methods |
|-------|---------|
| Identity | `id()`, `path()`, `default()` |
| Discovery | `discoverAutomatically()`, `discoverResources()`, `discoverPages()`, `discoverClusters()`, `discoverWidgets()`, `resources()`, `pages()`, `clusters()`, `widgets()` |
| Branding | `brandName()`, `brandLogo()`, `brandLogoHeight()`, `favicon()`, `colors()`, `font()`, `darkMode()` |
| Layout | `maxContentWidth()` |
| Middleware | `middleware()`, `authMiddleware()`, `authGuard()` |
| Navigation | `navigation()`, `userMenu()` |
| Auth | `login()`, `registration()`, `passwordReset()`, `emailVerification()`, `otp()`, `profile()`, `twoFactor()`, `socialLogin()`, `passkeys()`, `magicLinks()`, `connectedAccounts()`, `sessionManagement()`, `apiTokens()`, `localeTimezone()` |
| Notifications | `databaseNotifications()`, `databaseNotificationsPolling()`, `apiNotifications()` |
| AI | `globalSearch()`, `aiProviders()` |
| Plugins | `plugin()`, `plugins()` |
| Tenancy | `tenant()`, `multiDatabaseTenancy()`, `tenantRegistration()`, `tenantProfile()`, `tenantMenu()` |

## Panel Facade

```php
use Laravilt\Panel\Facades\Panel;

$panel = Panel::getCurrent();     // Panel handling the current request
$admin = Panel::get('admin');     // A panel by id
$default = Panel::getDefault();   // The default panel
$all = Panel::all();              // Collection of all panels
Panel::has('admin');              // bool
```

## Configuration File

Publish the package config:

```bash
php artisan vendor:publish --tag=laravilt-panel-config
```

This copies the file to `config/laravilt/panel.php`. It holds defaults that individual panels can override:

```php
return [
    'path' => env('LARAVILT_PANEL_PATH', 'admin'),
    'middleware' => ['web', 'auth'],
    'colors' => ['primary' => '#6366f1'],
    'brand_name' => env('APP_NAME', 'Laravilt'),
    'brand_logo' => null,
    'favicon' => null,
    'max_content_width' => '7xl',
];
```

## Publishing Assets

| Tag | Publishes |
|-----|-----------|
| `laravilt-panel-config` | Panel config |
| `laravilt-panel-lang` | Translations to `lang/vendor/laravilt-panel` |
| `laravilt-panel-views` | Panel frontend pages to `resources/js/pages/laravilt` |
| `laravilt-panel-assets` | Panel components to `resources/js/components/laravilt` |
| `laravilt-panel-ui` | UI primitives to `resources/js/components/ui` |
| `laravilt-panel-components` | The main nav component (`NavMain.vue` or `nav-main.tsx`) |

```bash
php artisan vendor:publish --tag=laravilt-panel-views
```

Frontend files are published for your stack: `.vue` files for Vue, `.tsx` files for React.

> React support requires Laravilt v1.1 or later.

## Next Steps

- [Discovery](discovery.md): register resources, pages and widgets
- [Branding & Theming](branding.md): customize the look
- [Panel Authentication](panel-auth.md): configure auth
