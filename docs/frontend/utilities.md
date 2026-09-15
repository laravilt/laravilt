---
title: Utilities
description: The cn, urlIsActive and toUrl helpers plus the composables and hooks shipped with the app shell.
order: 4
---

# Utilities

`resources/js/lib/utils.ts` is published for both stacks (tag `laravilt-panel-lib`) and exports the same three helpers.

> React support requires Laravilt v1.1 or later.

## cn()

Merges class names with `clsx` and resolves Tailwind conflicts with `tailwind-merge`:

```typescript
import { cn } from '@/lib/utils'

cn('px-4 py-2', isActive && 'bg-accent')   // conditional
cn('px-2', 'px-4')                         // => 'px-4'
cn('base', { 'opacity-50': disabled })     // object syntax
```

## urlIsActive()

`urlIsActive(urlToCheck, currentUrl)` is used by `NavMain` to highlight the current item:

```typescript
import { urlIsActive } from '@/lib/utils'

urlIsActive('/admin/users', '/admin/users')           // true
urlIsActive('/admin/users', '/admin/users/1/edit')    // true  (nested route)
urlIsActive('/admin', '/admin/users')                 // false (single-segment paths match exactly)
urlIsActive('/admin/cat', '/admin/categories')        // false (no partial segments)
urlIsActive('/admin/users', '/admin/users?page=2')    // true  (query string ignored)
urlIsActive('https://example.com/admin/users', '/admin/users') // true
```

`urlToCheck` may be a string or an Inertia link object (`{ url, method }`).

## toUrl()

Returns the URL string from a string or an Inertia link object:

```typescript
import { toUrl } from '@/lib/utils'

toUrl('/admin/users')                         // '/admin/users'
toUrl({ url: '/admin/users', method: 'get' }) // '/admin/users'
```

## Composables and Hooks

| Vue (`@/composables/...`) | React (`@/hooks/...`) | Purpose |
|---|---|---|
| `useAppearance` | `use-appearance` | Light / dark / system theme |
| `useInitials` | `use-initials` | Initials for avatar fallbacks |
| `useLocalization` | `use-localization` | Translations and locale |
| `usePanelFont` | `use-panel-font` | Loads the panel's configured font |
| `useTwoFactorAuth` | `use-two-factor-auth` | Two-factor setup helpers |

### Sidebar State

```typescript
// Vue
import { useSidebar } from '@/components/ui/sidebar'
const { state, open, setOpen, toggleSidebar, isMobile } = useSidebar()
const isCollapsed = computed(() => state.value === 'collapsed')
```

```tsx
// React
import { useSidebar } from '@/components/ui/sidebar';
const { state, toggleSidebar, isMobile } = useSidebar();
```

### Inertia Helpers

Use Inertia's own `usePage`, `useForm`, `Link` and `router` from `@inertiajs/vue3` or `@inertiajs/react`:

```typescript
import { useForm, usePage } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth?.user)

const form = useForm({ name: '', email: '' })
form.post('/profile', { onSuccess: () => form.reset() })
```

## Related

- [App Shell Components](components.md)
- [Styling & Theming](styling.md)
