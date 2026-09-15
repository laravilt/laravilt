---
title: Troubleshooting FAQ
description: Quick answers to common problems, with pointers to the full troubleshooting guide.
order: 7
---

# Troubleshooting FAQ

Most problems are covered in the [Troubleshooting guide](../getting-started/troubleshooting.md):

- [Assets not loading / styles missing](../getting-started/troubleshooting.md#assets-not-loading)
- [Vite build errors](../getting-started/troubleshooting.md#vite-build-errors)
- [Frontend component errors](../getting-started/troubleshooting.md#frontend-component-errors)
- [Database connection errors](../getting-started/troubleshooting.md#database-connection-errors)
- [Class not found](../getting-started/troubleshooting.md#class-not-found)
- [Session issues](../getting-started/troubleshooting.md#session-issues)

The questions below are not covered there.

## Laravilt's classes are missing from my CSS build

Tailwind v4 only scans the paths listed with `@source` in `resources/css/app.css`. Make sure the Laravilt vendor paths for your stack are present (`vendor/laravilt/*/resources/js/**` for Vue, `vendor/laravilt/*/resources/react/**` for React), then rebuild. See [Styling & Theming](../frontend/styling.md).

## I see Vue files but I chose React (or the other way round)

Check `LARAVILT_FRONTEND` in `.env` and clear the config cache (`php artisan config:clear`). Publish tags and generators follow this value. See [Frontend Stacks](../getting-started/frontend-stacks.md).

## I get a 403 on a resource

Laravilt respects your model policies. Check that the policy methods (`viewAny`, `view`, `create`, `update`, `delete`) return `true` for the user, and that the user can access the panel. See [Panel Auth](../panel/panel-auth.md).

## My form submits but nothing is saved

Check that the fields are `$fillable` on the model (or not `$guarded`), and that validation isn't failing silently on a hidden field. `dehydrated(false)` fields are never saved.

## How do I report a bug?

Open an issue on [GitHub](https://github.com/laravilt/laravilt/issues) and include your Laravilt, Laravel and PHP versions, your frontend stack (Vue or React), steps to reproduce, and expected versus actual behavior. You can also ask on [Discord](https://discord.gg/gyRhbVUXEZ).

## Related

- [Installation FAQ](installation.md)
