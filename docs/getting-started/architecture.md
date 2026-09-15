---
title: Architecture
description: How Laravilt's packages fit together and how a request becomes a rendered page.
order: 10
---

# Architecture

`laravilt/laravilt` is a meta-package. It installs these packages, each also usable on its own:

| Layer | Package | What it provides |
|-------|---------|------------------|
| Foundation | `laravilt/support` | Base `Component`, shared concerns, the `Frontend` stack resolver |
| Building blocks | `laravilt/schemas` | Layout: Section, Grid, Tabs, Wizard, Split, Fieldset |
| | `laravilt/forms` | 30+ form fields, validation, reactivity |
| | `laravilt/tables` | Columns, filters, sorting, grouping, pagination |
| | `laravilt/actions` | Buttons and modal actions (create, edit, delete, export, import…) |
| | `laravilt/infolists` | Read-only entries for view pages |
| | `laravilt/notifications` | Toast and database notifications |
| | `laravilt/widgets` | Stats and chart widgets |
| | `laravilt/query-builder` | Filtering and sorting for Eloquent queries |
| Application | `laravilt/panel` | Panels, resources, pages, navigation, tenancy |
| | `laravilt/auth` | Login, registration, 2FA, passkeys, social login, profile |
| Extensions | `laravilt/ai` | AI providers, chat, tools, agents, global search |
| | `laravilt/plugins` | Plugin system and generators |

Each PHP package ships its frontend next to it: Vue components in `resources/js`, React components in `resources/react` (v1.1+).

## How a page renders

```
Request → panel route & middleware → Resource page (PHP)
        → form / table / infolist built from fluent components
        → components serialized to props (toArray)
        → Inertia response
        → Vue or React page renders the props with Laravilt components
```

Components are defined once in PHP and serialized. The frontend packages render them, so the same resource works with both stacks.

## Core ideas

- **Panel:** a self-contained admin area with its own path, auth, theme and navigation, configured in a `PanelProvider`.
- **Resource:** binds an Eloquent model to a form, a table, an infolist and pages.
- **Components:** everything is `Component::make(...)` with chained configuration.

Next: [Panel & Resources](../panel/README.md).
