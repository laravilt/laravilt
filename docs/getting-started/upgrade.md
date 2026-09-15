---
title: Upgrading from 1.0
description: What changes in Laravilt v1.1 (Laravel 13, React) and how to upgrade an existing 1.0 app.
order: 9
---

# Upgrading from 1.0

Laravilt v1.1 adds:

- **Laravel 13** support. 1.0.x supports Laravel 11 and 12.
- **React 19** as a second frontend stack, next to Vue 3.
- A **stack setting**, `LARAVILT_FRONTEND` (`laravilt-support.frontend`), used by the installer, generators and publish tags.

Existing Vue apps keep working without changes.

## Steps for an existing Vue app

1. Update the packages:

   ```bash
   composer update "laravilt/*"
   ```

2. Pin the stack. Vue is also the automatic fallback, but being explicit makes generators predictable:

   ```env
   LARAVILT_FRONTEND=vue
   ```

3. Refresh the published frontend files and rebuild:

   ```bash
   php artisan vendor:publish --tag=laravilt-panel-views --force
   php artisan vendor:publish --tag=laravilt-panel-assets --force
   php artisan optimize:clear
   npm install && npm run build
   ```

   Review the diff if you customized published files.

4. To move to Laravel 13, follow Laravel's upgrade guide after step 1. Laravilt v1.1 supports both.

## Starting a React app

React needs a fresh app on Laravel's React starter kit. See [Installation](installation.md) and [Frontend Stacks](frontend-stacks.md). Converting an existing Vue app in place isn't supported.

## Migrating from Filament

See [Migrating from Filament](../panel/migration/README.md) (`php artisan laravilt:filament`).
