---
title: Configuration
description: The panel provider, published config files and environment keys.
order: 6
---

# Configuration

Most configuration lives in PHP, on the panel. Config files hold package-wide defaults.

## The panel provider

The installer generates `app/Providers/Laravilt/AdminPanelProvider.php`:

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
            ->passwordReset()
            ->profile()
            ->databaseNotifications()
            ->middleware(['web', 'auth'])
            ->authMiddleware(['auth']);
    }
}
```

`discoverAutomatically()` registers everything under `app/Laravilt/Admin/{Resources,Pages,Widgets}`. Common additions:

```php
->colors(['primary' => '#6366f1'])
->font('Inter')
->darkMode()
->favicon(asset('favicon.svg'))
```

See [Panel](../panel/README.md), [Branding](../panel/branding.md) and [Creating Panels](../panel/creating-panels.md). Add another panel with `php artisan laravilt:panel`.

## Environment

| Key | Purpose |
|-----|---------|
| `LARAVILT_FRONTEND` | `vue` or `react`. Written by the installer, and read by generators and publish tags. When empty, it's detected from `package.json`. |
| `APP_URL` | Must match the URL you browse (asset and passkey origins). |
| `SESSION_DRIVER`, `QUEUE_CONNECTION` | `database` works well for admin panels. |

AI providers and social login read their own keys (for example `OPENAI_API_KEY`). See [AI Providers](../ai/providers/README.md) and [Social Login](../auth/methods/social-auth.md).

## Config files

The installer publishes each package's config. To re-publish one, pass `--force` to overwrite:

```bash
php artisan vendor:publish --tag=laravilt-panel-config
php artisan vendor:publish --tag=laravilt-auth-config
```

| Tag | Package |
|-----|---------|
| `laravilt-panel-config` | Panel defaults |
| `laravilt-tenancy-config` | Multi-tenancy |
| `laravilt-auth-config` | Authentication |
| `laravilt-forms-config`, `laravilt-tables-config` | Form and table defaults |
| `laravilt-ai-config` | AI providers |

## Next

- [Frontend Stacks](frontend-stacks.md)
- [Troubleshooting](troubleshooting.md)
