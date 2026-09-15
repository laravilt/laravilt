---
title: Frontend Stacks
description: Choosing between Vue and React, what each installs, and how Laravilt picks the stack.
order: 7
---

# Frontend Stacks

Laravilt renders the same PHP definitions (panels, resources, forms, tables) with either stack. You pick one per application.

> React support requires Laravilt v1.1 or later. Laravilt 1.0.x is Vue only.

| | Vue | React |
|---|-----|-------|
| Framework | Vue 3 (`<script setup>`, TypeScript) | React 19 (TypeScript) |
| Inertia adapter | `@inertiajs/vue3` | `@inertiajs/react` v3 |
| UI primitives | shadcn-vue (Reka UI) | shadcn/ui (Radix) |
| Styling | Tailwind CSS v4 | Tailwind CSS v4 |
| Laravel starter kit | Vue | React |
| App entry | `resources/js/app.ts` | `resources/js/app.tsx` |
| Laravilt pages | published to `resources/js/pages/laravilt` | resolved from `vendor/` |

## Choosing the stack

- **Install:** `php artisan laravilt:install` asks, or pass `--stack=vue|react`.
- **Persisted:** the installer writes `LARAVILT_FRONTEND=vue|react` to `.env` (config key `laravilt-support.frontend`).
- **Fallback:** if the key is empty, `Laravilt\Support\Frontend::stack()` detects React when `package.json` depends on `react` or `@inertiajs/react` but not Vue. Otherwise it uses Vue.

Match the stack to your starter kit. Switching later means re-running the installer on a matching starter kit.

## Stack-aware generators

Generators follow the configured stack:

```bash
php artisan laravilt:page admin Reports      # resources/js/pages/Admin/Reports.vue or .tsx
php artisan make:form-component RatingInput --react   # PHP field + React component
php artisan make:form-component RatingInput --vue     # PHP field + Vue component
```

Publish tags do too: for example, `vendor:publish --tag=laravilt-panel-ui` publishes shadcn-vue or shadcn/ui components.

## Customizing the UI

Layouts, the sidebar and UI primitives are published into your app, so you own them. See [Frontend (Vue & React)](../frontend/README.md).
