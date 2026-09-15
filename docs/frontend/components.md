---
title: App Shell Components
description: The sidebar, header and navigation components published into your app, and the navigation item shape.
order: 2
---

# App Shell Components

These components make up the app shell. The installer publishes them to `resources/js/components/`, so they are yours to edit.

| Vue | React | Role |
|-----|-------|------|
| `AppShell.vue` | `app-shell.tsx` | Root wrapper (sidebar provider) |
| `AppSidebar.vue` | `app-sidebar.tsx` | Sidebar: logo, `NavMain`, `NavFooter`, `NavUser` |
| `AppSidebarHeader.vue` | `app-sidebar-header.tsx` | Top bar with sidebar trigger and breadcrumbs |
| `AppHeader.vue` | `app-header.tsx` | Header for the top-navigation layout |
| `AppContent.vue` | `app-content.tsx` | Main content area |
| `NavMain.vue` | `nav-main.tsx` | Panel navigation (groups, badges, active state) |
| `NavFooter.vue` / `NavUser.vue` | `nav-footer.tsx` / `nav-user.tsx` | Footer links and user menu |
| `Breadcrumbs.vue` | `breadcrumbs.tsx` | Breadcrumb trail |
| `AppLogo.vue` / `AppLogoIcon.vue` | `app-logo.tsx` / `app-logo-icon.tsx` | Branding |
| `AppearanceTabs.vue` | `appearance-tabs.tsx` | Light / dark / system switch |
| `Heading.vue`, `InputError.vue`, `TextLink.vue`, ... | `heading.tsx`, `input-error.tsx`, `text-link.tsx`, ... | Small helpers |

> React support requires Laravilt v1.1 or later.

## Navigation

Panel navigation is built in PHP (resources, pages, clusters, groups) and shared with the frontend as the panel's `navigation` prop. `NavMain` renders it:

- **Groups.** Items with `type: 'group'` and nested `items` render as collapsible groups. In icon-collapsed mode they render as dropdowns.
- **Badges.** `badge` / `badgeCount` with `badgeColor` (`primary`, `success`, `danger`, `warning`, `info`, `gray`, `secondary`).
- **Active state.** `urlIsActive()` from `@/lib/utils`, plus `activeMatchPrefix` for clusters.

The navigation item shape (React: `resources/js/types/navigation.ts`):

```typescript
type NavItem = {
    title: string
    href: string | { url: string; method: string }
    icon?: LucideIcon | null
    isActive?: boolean
    type?: 'item' | 'group'
    url?: string
    items?: NavItem[]
    collapsed?: boolean
    badge?: string | number | null
    badgeCount?: string | number | null
    badgeColor?: string | null
    activeMatchPrefix?: string | null // active for every URL under this prefix (clusters)
}
```

To configure navigation itself (labels, icons, groups, sorting, badges), use PHP. See [Navigation](../panel/navigation/README.md). Edit `NavMain` only when you want to change how navigation *looks*.

To restore the stock `NavMain` after editing it:

```bash
php artisan vendor:publish --tag=laravilt-panel-components --force
```

## Laravilt Page Components

The components that render resources (the list page with table/grid views, forms, infolists, relation managers, tenant switcher and so on) ship inside the packages (`vendor/laravilt/*/resources/js` or `resources/react`) and are rendered from your PHP schema. You normally don't touch them. If you need to, publish the panel components to `resources/js/components/laravilt`:

```bash
php artisan vendor:publish --tag=laravilt-panel-assets
```

For a new field type, create a custom form component instead of editing package code:

```bash
php artisan make:form-component ColorSwatch --vue    # or --react
```

See [Forms](../forms/README.md).

## Related

- [Layouts](layouts.md)
- [UI Components](ui/README.md)
- [Utilities](utilities.md)
