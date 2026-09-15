---
title: Installation FAQ
description: Questions about requirements, frontend stacks, installing and updating Laravilt.
order: 1
---

# Installation FAQ

## How do I install Laravilt?

In a Laravel 13 application:

```bash
composer require laravilt/laravilt
php artisan laravilt:install
```

The installer asks for your frontend stack, publishes the frontend files, runs migrations, installs and builds npm dependencies, and creates a panel. It accepts these options:

| Option | Effect |
|--------|--------|
| `--stack=vue\|react` | Choose the stack without prompting |
| `--skip-migrations` | Don't run migrations |
| `--skip-npm` | Don't run `npm install` / build |
| `--skip-panel` | Don't create a panel |

See [Installation](../getting-started/installation.md) for the full walkthrough.

## What are the requirements?

| Requirement | Version |
|-------------|---------|
| PHP | 8.3+ |
| Laravel | 13 |
| Node.js | 20.19+ (required by Vite) |
| Composer | 2.x |
| Database | Any database Laravel supports (MySQL, MariaDB, PostgreSQL, SQLite, SQL Server) |

See [Requirements](../getting-started/requirements.md).

## Can I use React instead of Vue?

Yes. Laravilt supports **Vue 3** (shadcn-vue / Reka UI) and **React 19** (shadcn/ui / Radix UI). Both use Inertia and Tailwind CSS v4.

> React support requires Laravilt v1.1 or later.

Choose with `php artisan laravilt:install --stack=react`. The choice is stored as `LARAVILT_FRONTEND=react` in `.env`, and generators such as `laravilt:page` then create `.tsx` files. See [Frontend Stacks](../getting-started/frontend-stacks.md) and [Frontend (Vue & React)](../frontend/README.md).

## Can I switch stacks later?

Change `LARAVILT_FRONTEND` and re-run `php artisan laravilt:install --stack=<stack>` so that the matching `package.json`, Vite config, entry point, layouts and components get published. The installer overwrites these frontend files, so commit first and move any custom pages over by hand.

## How do I update Laravilt?

```bash
composer update "laravilt/*"
npm install && npm run build
php artisan migrate
```

There is no separate upgrade command. If a release changes the published shell files (layouts, `components/ui`, `lib/utils.ts`), republish only what you haven't customized, for example `php artisan vendor:publish --tag=laravilt-panel-ui --force`. See [Upgrade Guide](../getting-started/upgrade.md).

## How do I create another panel?

A panel is a `PanelProvider`:

```php
<?php

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
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification();
    }
}
```

See [Creating Panels](../panel/creating-panels.md) and [Auth](../auth/README.md).

## How do I change the colors?

```php
return $panel
    ->colors(['primary' => '#FF2D20'])
    ->darkMode()
    ->favicon('/favicon.ico');
```

For deeper changes, edit the CSS variables in `resources/css/app.css`. See [Branding](../panel/branding.md) and [Styling & Theming](../frontend/styling.md).

## How do I republish frontend files?

Use the specific package tags. There is no `laravilt-assets` tag. For the panel:

```bash
php artisan vendor:publish --tag=laravilt-panel-ui          # UI primitives
php artisan vendor:publish --tag=laravilt-panel-lib         # lib/utils.ts
php artisan vendor:publish --tag=laravilt-panel-components  # NavMain
php artisan vendor:publish --tag=laravilt-panel-config      # config/laravilt/panel.php
```

Run `php artisan vendor:publish` without arguments to list all tags.

## Is there a demo?

Yes: [demo.laravilt.com](https://demo.laravilt.com) (login `admin@laravilt.com` / `password`).

## Related

- [Quick Start](../getting-started/quick-start.md)
- [Configuration](../getting-started/configuration.md)
