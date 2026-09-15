---
title: Frontend Components
description: The Vue and React components that render Laravilt tables.
order: 2
---

# Frontend Components

Tables render on the frontend stack you chose when you ran `php artisan laravilt:install --stack=vue|react` (see [Frontend Stacks](../../getting-started/frontend-stacks.md)). The `laravilt/tables` package ships the same component set for both stacks:

| Component | Vue (`resources/js/components`) | React (`resources/react/components`) |
|-----------|------|-------|
| Table wrapper with toolbar, filters, and actions | `Table.vue` | `Table.tsx` |
| Row/column table | `DataTable.vue` | `DataTable.tsx` |
| Grid view | `CardGrid.vue`, `GridToolbar.vue` | `CardGrid.tsx`, `GridToolbar.tsx` |
| Toolbar | `TableToolbar.vue` | `TableToolbar.tsx` |
| API tester | `ApiTester.vue` | `ApiTester.tsx` |
| Cell renderers | `columns/{Text,Icon,Image,Color,Toggle,Select,TextInput,Checkbox}Column.vue` | `columns/{Text,Icon,Image,Color,Toggle,Select,TextInput,Checkbox}Column.tsx` |
| Inline-edit state for editable cells | `composables/useColumnUpdate.ts` | `composables/useColumnUpdate.ts` |
| Grid cell renderers | `grid-columns/*GridColumn.vue` | `grid-columns/*GridColumn.tsx` |

> React support requires Laravilt v1.1 or later.

The Vue components use shadcn-vue (reka-ui) and `lucide-vue-next`. The React components use shadcn/ui and `lucide-react`. Both are styled with Tailwind CSS v4.

## How rendering works

You don't write frontend code to build a table. The PHP `Table` is serialized to Inertia props (columns, filters, actions, records, pagination), and the panel page passes them to `Table`. Each column's `component` prop picks its cell renderer:

| PHP column | Renderer |
|------------|----------|
| `TextColumn`, `BadgeColumn` | `TextColumn` |
| `IconColumn`, `BooleanColumn` | `IconColumn` |
| `ImageColumn` | `ImageColumn` |
| `ColorColumn` | `ColorColumn` |
| `ToggleColumn` | `ToggleColumn` |
| `SelectColumn` | `SelectColumn` |
| `TextInputColumn` | `TextInputColumn` |
| `CheckboxColumn` | `CheckboxColumn` |
| Anything else | falls back to `TextColumn` |

`ToggleColumn`, `SelectColumn`, `TextInputColumn`, and `CheckboxColumn` save through the table's `columnUpdateRoute` prop (see [Editable columns](../columns/README.md#editable-columns)). The `useColumnUpdate` composable holds the shared optimistic-save logic.

Filters render with Laravilt form components, and row actions render with the `ActionButton` component from `laravilt/actions`.

## Publishing assets

```bash
php artisan tables:install          # publish assets
php artisan tables:install --force  # overwrite previously published files
```
