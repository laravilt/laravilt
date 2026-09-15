---
title: Support
description: Base classes, traits and helpers shared by every Laravilt package.
order: 16
---

# Support Package

`laravilt/support` is the foundation the other packages build on. It provides the `Component` base class, reusable traits for labels, visibility, state and so on, the `Get`/`Set` helpers injected into closures, RTL detection, colors, and frontend stack detection. It is installed automatically as a dependency, so you usually use it only when building your own components or plugins.

## In this section

1. [Component](component.md): the base class for UI components and how it serializes
2. [Concerns](concerns/README.md): the traits every component uses
3. [Utilities](utilities.md): `Get`, `Set`, `Translator`, `Color` and `Frontend`

## Frontend stack

Laravilt supports Vue 3 (shadcn-vue / reka-ui) and React 19 (shadcn/ui). `Laravilt\Support\Frontend` reports which stack the app uses. It reads the `laravilt-support.frontend` config key (env `LARAVILT_FRONTEND`, written by `laravilt:install --stack=vue|react`), and otherwise detects the stack from `package.json`, falling back to Vue:

```php
use Laravilt\Support\Frontend;

Frontend::stack();              // 'vue' or 'react'
Frontend::isReact();
Frontend::resourceDirectory();  // 'js' for Vue, 'react' for React
```

> React support requires Laravilt v1.1 or later.

See [Utilities](utilities.md#frontend) and [Frontend Stacks](../getting-started/frontend-stacks.md).

## Facade

```php
use Laravilt\Support\Facades\Laravilt;

Laravilt::isLaraviltRequest();
Laravilt::wantsJson();
Laravilt::generateKey();
Laravilt::auth();  // Laravilt\Auth\AuthManager (requires laravilt/auth)
```

## Commands

```bash
php artisan support:install [--force] [--without-assets]
php artisan laravilt:component {name} [--force]
```

## Related

- [Schemas](../schemas/README.md)
- [Forms](../forms/README.md)
