---
title: Layouts
description: Page layouts and structure for Laravilt admin panels.
---

# Layouts

Laravilt provides several layouts for different page types.

## Available Layouts

### AppLayout (Default)

The main admin panel layout with sidebar, header, and content area:

```vue
<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="p-6">
            <h1>Dashboard Content</h1>
        </div>
    </AppLayout>
</template>
```

**Features:**
- Collapsible sidebar
- Top header with global search
- User menu
- Breadcrumbs support
- Theme switching

### AuthLayout

Simple centered layout for authentication pages:

```vue
<script setup lang="ts">
import AuthLayout from '@/layouts/AuthLayout.vue'
</script>

<template>
    <AuthLayout title="Login">
        <form class="space-y-4">
            <!-- Login form -->
        </form>
    </AuthLayout>
</template>
```

**Features:**
- Centered card
- Logo display
- Clean background

### GuestLayout

Public pages layout without authentication:

```vue
<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue'
</script>

<template>
    <GuestLayout>
        <div class="min-h-screen">
            <!-- Public page content -->
        </div>
    </GuestLayout>
</template>
```

## Layout Structure

### AppLayout Anatomy

```
┌─────────────────────────────────────────────────────────┐
│ AppHeader (fixed top)                                   │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ Logo │ Global Search │ Theme │ User Menu            │ │
│ └─────────────────────────────────────────────────────┘ │
├──────────┬──────────────────────────────────────────────┤
│          │                                              │
│ AppSide- │ AppContent                                   │
│ bar      │                                              │
│          │ ┌──────────────────────────────────────────┐ │
│ ┌──────┐ │ │ Page Header (title, actions)            │ │
│ │NavMain│ │ └──────────────────────────────────────────┘ │
│ └──────┘ │                                              │
│          │ ┌──────────────────────────────────────────┐ │
│ ┌──────┐ │ │                                          │ │
│ │NavFtr │ │ │ Slot Content                            │ │
│ └──────┘ │ │                                          │ │
│          │ └──────────────────────────────────────────┘ │
└──────────┴──────────────────────────────────────────────┘
```

### Sidebar States

**Expanded:**
- Full width (256px default)
- Icon + text navigation items
- Group labels visible
- Full user info display

**Collapsed:**
- Icon-only width (64px)
- Navigation groups become dropdowns
- Tooltips on hover
- Mini user avatar

## Using Layouts

### With Inertia Pages

```vue
<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'

defineProps<{
    title: string
}>()
</script>

<template>
    <AppLayout :title="title">
        <Head :title="title" />

        <div class="p-6">
            <slot />
        </div>
    </AppLayout>
</template>
```

### With Page Actions

```vue
<template>
    <AppLayout title="Users">
        <template #header>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">Users</h1>
                <Button @click="createUser">
                    <Plus class="mr-2 h-4 w-4" />
                    Create User
                </Button>
            </div>
        </template>

        <div class="p-6">
            <!-- Content -->
        </div>
    </AppLayout>
</template>
```

### With Breadcrumbs

```vue
<script setup lang="ts">
const breadcrumbs = [
    { title: 'Dashboard', href: '/admin' },
    { title: 'Users', href: '/admin/users' },
    { title: 'Edit User' },
]
</script>

<template>
    <AppLayout title="Edit User" :breadcrumbs="breadcrumbs">
        <!-- Content -->
    </AppLayout>
</template>
```

## Customizing Layouts

### Custom Sidebar Width

```css
/* In your global CSS */
:root {
    --sidebar-width: 280px;
    --sidebar-collapsed-width: 72px;
}
```

### Custom Theme Colors

```css
:root {
    --primary: 3.5 100% 56.3%;       /* #FF2D20 */
    --brand-accent: 266.4 77.3% 62%; /* #9553E9 */
}

.dark {
    --primary: 3.5 100% 56.3%;
    --brand-accent: 266.4 77.3% 62%;
}
```

### Adding Layout Slots

Create a custom layout with additional slots:

```vue
<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
</script>

<template>
    <AppLayout v-bind="$attrs">
        <template #sidebar-header>
            <slot name="sidebar-header" />
        </template>

        <template #sidebar-footer>
            <slot name="sidebar-footer" />
        </template>

        <slot />
    </AppLayout>
</template>
```

## Responsive Behavior

### Mobile Sidebar

On mobile devices (`< 768px`):
- Sidebar becomes an overlay sheet
- Toggle button in header
- Swipe to close support
- Dark backdrop when open

### Tablet Mode

On tablets (`768px - 1024px`):
- Sidebar defaults to collapsed
- Can be expanded by user
- Content uses full width

### Desktop Mode

On desktop (`> 1024px`):
- Sidebar defaults to expanded
- Collapsible with toggle
- Content respects sidebar width

## Best Practices

### Use Semantic Structure

```vue
<template>
    <AppLayout title="Page Title">
        <main class="p-6">
            <header class="mb-6">
                <h1>Page Heading</h1>
            </header>

            <section>
                <!-- Main content -->
            </section>
        </main>
    </AppLayout>
</template>
```

### Handle Loading States

```vue
<template>
    <AppLayout title="Data">
        <div v-if="loading" class="flex items-center justify-center p-12">
            <Spinner />
        </div>

        <div v-else>
            <!-- Content -->
        </div>
    </AppLayout>
</template>
```

### Persist User Preferences

Sidebar state and theme preferences are automatically persisted in localStorage.
