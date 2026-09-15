---
title: Frontend (Vue & React)
description: How the Laravilt frontend is structured for the Vue and React stacks, and how to customize it.
order: 14
---

# Frontend (Vue & React)

Laravilt renders every panel with Inertia.js. You build resources, pages, forms and tables in PHP. The frontend shell (layouts, sidebar, header, UI primitives) is published into your application, so you own it and can change it.

Two frontend stacks are supported:

| | Vue stack | React stack |
|---|---|---|
| Framework | Vue 3 (`<script setup>`, TypeScript) | React 19 (TypeScript) |
| UI primitives | shadcn-vue (Reka UI) | shadcn/ui (Radix UI) |
| Inertia adapter | `@inertiajs/vue3` | `@inertiajs/react` v3 + `@inertiajs/vite` |
| Icons | `lucide-vue-next` | `lucide-react` |
| Styling | Tailwind CSS v4 | Tailwind CSS v4 |
| Entry point | `resources/js/app.ts` | `resources/js/app.tsx` |

> React support requires Laravilt v1.1 or later.

## Choosing a Stack

The stack is chosen when you install:

```bash
php artisan laravilt:install --stack=vue    # or --stack=react
```

Without `--stack`, the installer asks, defaulting to the stack it detects in your `package.json`. The choice is written to `.env` and `.env.example`:

```env
LARAVILT_FRONTEND=vue
```

It is read from the `laravilt-support.frontend` config key. In PHP you can check it with `Laravilt\Support\Frontend::stack()`, `Frontend::isVue()` or `Frontend::isReact()`. Generators follow the stack. For example, `php artisan laravilt:page` creates `resources/js/pages/{Panel}/{Name}.vue` or `.tsx`, and `php artisan make:form-component {name} --vue|--react` scaffolds a custom form component.

See [Frontend Stacks](../getting-started/frontend-stacks.md) for a full comparison.

## What Gets Published

**Vue stack.** The installer publishes `package.json`, `vite.config.ts`, `resources/js/app.ts`, `resources/css/app.css`, and these app-owned folders under `resources/js/`:

```
resources/js/
├── app.ts
├── components/        # AppSidebar.vue, AppHeader.vue, NavMain.vue, NavUser.vue, Breadcrumbs.vue ...
│   └── ui/            # shadcn-vue primitives (button, card, dialog, sidebar ...)
├── composables/       # useAppearance.ts, useInitials.ts, useLocalization.ts ...
├── layouts/           # AppLayout.vue, AuthLayout.vue, app/, auth/, settings/
├── lib/utils.ts       # cn(), urlIsActive(), toUrl()
├── pages/             # your own Inertia pages
└── types/
```

**React stack.** The installer publishes the files listed in the panel package's `stubs/react/manifest.php`:

```
resources/js/
├── app.tsx
├── components/        # app-sidebar.tsx, app-header.tsx, nav-main.tsx, nav-user.tsx ...
│   └── ui/            # shadcn/ui primitives (button, card, dialog, sidebar ...)
├── hooks/             # use-appearance.tsx, use-initials.tsx, use-localization.ts ...
├── layouts/           # app-layout.tsx, auth-layout.tsx, app/, auth/
├── lib/utils.ts       # cn(), urlIsActive(), toUrl()
├── pages/             # your own Inertia pages
└── types/
```

## Where Laravilt Pages Come From

The resource list, create, edit and view pages, the dashboard and the auth pages are **not** copied into your app. They are resolved straight from `vendor/`. Your `app.ts` / `app.tsx` resolves an Inertia page in this order:

1. `resources/js/pages/` (your pages, which can override a vendor page with the same name)
2. `vendor/laravilt/panel/resources/{js|react}/pages`
3. `vendor/laravilt/auth/...`
4. `vendor/laravilt/ai/...`

Vite aliases `@laravilt/<package>` to `vendor/laravilt/<package>/resources/js` (Vue) or `resources/react` (React), so package sources are compiled as part of your app. For example, the entry point imports `@laravilt/forms/app` and `@laravilt/notifications/app`.

## Importing Components

UI primitives live in your app, so import them with the `@/` alias:

```vue
<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { ref } from 'vue'

const name = ref('')
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>Create User</CardTitle>
        </CardHeader>
        <CardContent class="space-y-4">
            <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input id="name" v-model="name" placeholder="Enter name" />
            </div>
            <Button type="submit">Create</Button>
        </CardContent>
    </Card>
</template>
```

```tsx
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useState } from 'react';

export default function CreateUser() {
    const [name, setName] = useState('');

    return (
        <Card>
            <CardHeader>
                <CardTitle>Create User</CardTitle>
            </CardHeader>
            <CardContent className="space-y-4">
                <div className="grid gap-2">
                    <Label htmlFor="name">Name</Label>
                    <Input id="name" value={name} onChange={(e) => setName(e.target.value)} />
                </div>
                <Button type="submit">Create</Button>
            </CardContent>
        </Card>
    );
}
```

## Republishing Frontend Files

The panel package registers these publish tags (they follow the configured stack):

| Tag | Publishes |
|-----|-----------|
| `laravilt-panel-ui` | UI primitives to `resources/js/components/ui` |
| `laravilt-panel-lib` | `resources/js/lib/utils.ts` |
| `laravilt-panel-components` | `NavMain.vue` / `nav-main.tsx` |
| `laravilt-panel-views` | Panel pages to `resources/js/pages/laravilt` (to override them) |
| `laravilt-panel-assets` | Panel components to `resources/js/components/laravilt` |

```bash
php artisan vendor:publish --tag=laravilt-panel-ui --force
```

`--force` overwrites your customized files, so commit your work first.

## In This Section

- [Layouts](layouts.md): app and auth layouts, breadcrumbs, sidebar behavior
- [App Shell Components](components.md): sidebar, header, NavMain and navigation items
- [Styling & Theming](styling.md): Tailwind CSS v4, theme variables, dark mode
- [Utilities](utilities.md): `cn()`, `urlIsActive()`, composables and hooks
- [UI Components](ui/README.md): the shadcn primitives catalog
- [Form Inputs](forms/README.md): input, select, checkbox and switch primitives

## Related

- [Panel](../panel/README.md)
- [Widgets](../widgets/README.md) (dashboard charts and stats are built in PHP)
- Live demo: [demo.laravilt.com](https://demo.laravilt.com) (login `admin@laravilt.com` / `password`)
