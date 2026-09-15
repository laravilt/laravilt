---
title: UI Components
description: The shadcn-vue and shadcn/ui primitives published into your app, with import paths for both stacks.
order: 5
---

# UI Components

Laravilt doesn't ship a separate UI component library. The installer copies the **shadcn** primitives into your app at `resources/js/components/ui/`: shadcn-vue (Reka UI) for Vue, shadcn/ui (Radix UI) for React. Import them with the `@/` alias:

```typescript
// Vue
import { Button } from '@/components/ui/button'
import { Dialog, DialogContent, DialogTrigger } from '@/components/ui/dialog'
```

```tsx
// React
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogTrigger } from '@/components/ui/dialog';
```

The import paths are the same on both stacks. Only the file format differs: Vue components live in `ui/<name>/` folders with an `index.ts`, and React components are single `ui/<name>.tsx` files.

> React support requires Laravilt v1.1 or later.

Because the files are yours, you can edit variants directly or add more components with the shadcn CLI (`npx shadcn-vue@latest add ...` / `npx shadcn@latest add ...`). To restore the originals, run `php artisan vendor:publish --tag=laravilt-panel-ui --force`.

## Available Primitives

Shipped with **both** stacks: alert, avatar, badge, breadcrumb, button, card, checkbox, collapsible, dialog, dropdown-menu, input, label, navigation-menu, popover, radio-group, scroll-area, select, separator, sheet, sidebar, skeleton, spinner, switch, tabs, textarea, tooltip.

**Vue only:** pin-input.

**React only:** accordion, alert-dialog, calendar, command, context-menu, hover-card, input-otp, pagination, progress, slider, sonner (toasts), table, toggle, toggle-group.

## Documented Here

| Component | Page |
|-----------|------|
| Button | [Button](button.md) |
| Card | [Card](card.md) |
| Badge | [Badge](badge.md) |
| Alert | [Alert](alert.md) |
| Avatar | [Avatar](avatar.md) |
| Dialog | [Dialog](dialog.md) |
| Sheet | [Sheet](sheet.md) |
| Dropdown Menu | [Dropdown Menu](dropdown.md) |
| Tabs | [Tabs](tabs.md) |
| Tooltip | [Tooltip](tooltip.md) |

Form primitives (input, select, checkbox, switch) are covered in [Form Inputs](../forms/README.md). For everything else, the upstream docs apply unchanged: [shadcn-vue](https://www.shadcn-vue.com/docs/components) and [shadcn/ui](https://ui.shadcn.com/docs/components).

## Syntax Differences at a Glance

| | Vue | React |
|---|---|---|
| Class prop | `class="..."` | `className="..."` |
| Two-way binding | `v-model="value"` | `value` + `onValueChange` / `onChange` |
| Composition | `as-child` | `asChild` |
| Icons | `lucide-vue-next` | `lucide-react` |

## Related

- [Styling & Theming](../styling.md)
- [Form Inputs](../forms/README.md)
