---
title: Installation
description: Create a Laravel app, choose Vue or React, and install Laravilt with one command.
order: 2
---

# Installation

Check the [requirements](requirements.md) first.

## 1. Create a Laravel app

```bash
laravel new my-app
cd my-app
```

When asked for a starter kit, pick **Vue** or **React**. Laravilt uses that stack for its panel.

> React support requires Laravilt v1.1 or later.

## 2. Require Laravilt

```bash
composer require laravilt/laravilt
```

This pulls in every Laravilt package: support, panel, auth, forms, tables, actions, schemas, infolists, notifications, widgets, query-builder, ai and plugins.

## 3. Run the installer

```bash
php artisan laravilt:install
```

The installer:

1. Asks for the frontend stack (Vue or React). The default is detected from your `package.json`.
2. Asks for the panel ID (default `admin`) and which features to enable: login, registration, 2FA, passkeys, social login, API tokens, AI and more.
3. Publishes the frontend for that stack, the configs and brand icons, and writes `LARAVILT_FRONTEND=vue|react` to `.env` and `.env.example`.
4. Runs migrations, creates `app/Providers/Laravilt/AdminPanelProvider.php` and the `app/Laravilt/Admin/` folders, and registers the provider in `bootstrap/providers.php`.
5. Runs `npm install` and `npm run build`.
6. Optionally creates an admin user (`php artisan laravilt:user`).

[Installer Prompts](interactive-install.md) lists every question.

### Options

| Option | Effect |
|--------|--------|
| `--stack=vue` / `--stack=react` | Skip the stack question. |
| `--skip-migrations` | Don't run `migrate`. |
| `--skip-npm` | Don't run `npm install` / `npm run build`. |
| `--skip-panel` | Don't create a panel. Create one later with `php artisan laravilt:panel`. |

For example, a React install that you build yourself:

```bash
php artisan laravilt:install --stack=react --skip-npm
npm install && npm run build
```

The installer overwrites starter-kit files such as `package.json`, `vite.config.ts`, `resources/js/app.*`, `routes/web.php` and `app/Models/User.php`. Run it on a fresh app, or commit your work first.

## 4. Create an admin user

If you skipped it during install:

```bash
php artisan laravilt:user
# or non-interactively
php artisan laravilt:user --name="Admin" --email=admin@example.com --password=secret
```

## 5. Open the panel

```bash
composer run dev   # or: php artisan serve
```

Visit `http://localhost:8000/admin` (or your Herd/Valet domain) and log in.

## Next

- [Quick Start](quick-start.md): generate your first resource.
- [Troubleshooting](troubleshooting.md) if something didn't work.
