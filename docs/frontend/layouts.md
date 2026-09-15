---
title: Layouts
description: The app and auth layouts published into your application and how to customize them.
order: 1
---

# Layouts

The installer publishes the layouts into `resources/js/layouts/`. They are ordinary app files, so you can edit them.

| Vue | React | Purpose |
|-----|-------|---------|
| `AppLayout.vue` | `app-layout.tsx` | Authenticated app shell (wraps the sidebar layout) |
| `app/AppSidebarLayout.vue` | `app/app-sidebar-layout.tsx` | Sidebar + header + content (default) |
| `app/AppHeaderLayout.vue` | `app/app-header-layout.tsx` | Top navigation variant |
| `AuthLayout.vue` | `auth-layout.tsx` | Auth pages (wraps the simple auth layout) |
| `auth/AuthSimpleLayout.vue` | `auth/auth-simple-layout.tsx` | Centered form |
| `auth/AuthCardLayout.vue` | `auth/auth-card-layout.tsx` | Form in a card |
| `auth/AuthSplitLayout.vue` | `auth/auth-split-layout.tsx` | Split screen |
| `settings/Layout.vue` | (none) | Settings pages (Vue only) |

> React support requires Laravilt v1.1 or later.

Laravilt resource pages (list, create, edit, view) use the panel's own layout from `vendor/laravilt/panel`. The published layouts are for your own Inertia pages and for the app shell.

## AppLayout

`AppLayout` takes an optional `breadcrumbs` prop (`{ title, href }[]`) and renders the page in its default slot or children.

```vue
<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import type { BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Reports', href: '/admin/reports' },
]
</script>

<template>
    <Head title="Reports" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <h1 class="text-2xl font-semibold">Reports</h1>
        </div>
    </AppLayout>
</template>
```

```tsx
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Reports', href: '/admin/reports' },
];

export default function Reports() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Reports" />
            <div className="p-6">
                <h1 className="text-2xl font-semibold">Reports</h1>
            </div>
        </AppLayout>
    );
}
```

The sidebar layout composes `AppShell`, `AppSidebar`, `AppContent` and `AppSidebarHeader`, which shows the breadcrumbs. On Vue it also mounts the notification container that displays session notifications. See [App Shell Components](components.md).

## Switching to the Header Layout

To use top navigation instead of a sidebar, point `AppLayout` at the header layout:

```vue
<!-- resources/js/layouts/AppLayout.vue -->
<script setup lang="ts">
import AppLayout from '@/layouts/app/AppHeaderLayout.vue'
// ...
</script>
```

```tsx
// resources/js/layouts/app-layout.tsx
import AppLayoutTemplate from '@/layouts/app/app-header-layout';
```

## AuthLayout

`AuthLayout` accepts `title` and `description` and wraps `AuthSimpleLayout`. To use the card or split variant, change the import in `AuthLayout.vue` / `auth-layout.tsx`.

```vue
<script setup lang="ts">
import AuthLayout from '@/layouts/AuthLayout.vue'
</script>

<template>
    <AuthLayout title="Log in" description="Enter your email and password">
        <!-- form -->
    </AuthLayout>
</template>
```

The panel login, registration and password pages come from `laravilt/auth`. See [Auth](../auth/README.md).

## Sidebar Behavior

The sidebar is the shadcn `Sidebar` primitive (`@/components/ui/sidebar`):

- **Expanded / collapsed.** In collapsed (icon) mode, navigation groups open as dropdowns.
- **Mobile.** The sidebar becomes an off-canvas sheet.
- **State.** Read or toggle it with `useSidebar()` (see [Utilities](utilities.md)).

The width is set by the `--sidebar-width` and `--sidebar-width-icon` CSS variables in the sidebar provider component, so edit them there or override them in CSS.

## Related

- [App Shell Components](components.md)
- [Styling & Theming](styling.md)
- [Panel Layout](../panel/layout.md)
