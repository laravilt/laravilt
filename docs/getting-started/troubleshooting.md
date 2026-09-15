---
title: Troubleshooting
description: Fixes for the most common installation and setup problems.
order: 8
---

# Troubleshooting

Start with `storage/logs/laravel.log` and the browser console. Most problems show up in one of them.

## Blank page or missing styles

The frontend isn't built, or you're running a stale build.

```bash
npm install
npm run build        # or keep `npm run dev` running
php artisan optimize:clear
```

Check that `APP_URL` matches the URL you open.

## "Page not found" for a Laravilt page / Inertia can't resolve a component

- **Vue:** the panel pages must be published. Re-run `php artisan vendor:publish --tag=laravilt-panel-views --force`, then rebuild.
- **React:** pages resolve from `vendor/`. Run `composer install`, then rebuild.
- Make sure `LARAVILT_FRONTEND` in `.env` matches your starter kit (`vue` or `react`), then run `php artisan config:clear`.

## The installer ran with the wrong stack

Set `LARAVILT_FRONTEND` correctly and re-run the installer with an explicit stack on a starter kit of that stack:

```bash
php artisan laravilt:install --stack=react
```

## `/admin` returns 404

- The panel provider must be listed in `bootstrap/providers.php` (the installer adds `App\Providers\Laravilt\AdminPanelProvider::class`).
- Run `php artisan route:clear` and `php artisan optimize:clear`.
- The panel `->path()` sets the URL prefix.

## Login loops or "CSRF token mismatch"

- `APP_URL`, `SESSION_DOMAIN` and the browser URL must agree (same host and scheme).
- With `SESSION_DRIVER=database`, the `sessions` table must exist (`php artisan migrate`).

## A resource doesn't appear in the navigation

- It must live under `app/Laravilt/{Panel}/Resources/{Name}/{Name}Resource.php` for auto-discovery.
- Check `canViewAny()` / policies. See [Authorization](../panel/resources/authorization.md).

## npm install or the build fails

```bash
rm -rf node_modules package-lock.json
npm install
npm run build
```

Use Node.js 20 or newer.

## Class "Laravilt\..." not found

```bash
composer dump-autoload
php artisan optimize:clear
```

## Still stuck?

- Compare with the [live demo](https://demo.laravilt.com) (`admin@laravilt.com` / `password`).
- Ask your AI assistant through the [Laravilt MCP server](../mcp/README.md).
- Search or open an issue on [GitHub](https://github.com/laravilt/laravilt/issues).
- See the [FAQ](../faq/README.md).
