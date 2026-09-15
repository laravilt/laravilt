---
title: Columns
description: Column types available for Laravilt tables and the options they share.
order: 1
---

# Columns

Columns live in the `Laravilt\Tables\Columns` namespace. Pass them to `$table->columns([...])`.

| Column | Purpose |
|--------|---------|
| [TextColumn](text-column.md) | Text, badges, dates, money, numbers, and summaries |
| [ImageColumn](image-column.md) | Single or stacked images |
| [IconColumn](icon-column.md) | Lucide icons, including boolean mode |
| [ColorColumn](color-column.md) | Color swatches |
| [ToggleColumn](toggle-column.md) | Inline on/off switch that saves to the database |
| [SelectColumn](select-column.md) | Inline dropdown that saves to the database |
| [TextInputColumn](text-input-column.md) | Inline text input that saves to the database |
| [CheckboxColumn](checkbox-column.md) | Inline checkbox that saves to the database |

`BadgeColumn` (a `TextColumn` with a `colors()` map) and `BooleanColumn` (an `IconColumn` in boolean mode) are also available.

## Shared options

Every column extends `Laravilt\Tables\Columns\Column`:

```php
use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('name')
    ->label('Full name')
    ->searchable()
    ->sortable()
    ->toggleable(isToggledHiddenByDefault: false)
    ->description(fn ($record) => $record->email)
    ->tooltip('Customer name')
    ->url(fn ($record) => route('users.show', $record), openInNewTab: true)
    ->alignEnd()
    ->width('200px')
    ->visible(fn () => auth()->user()->isAdmin());
```

| Method | Description |
|--------|-------------|
| `label()` | Column header |
| `sortable()` | Allow sorting by this column. See [Sorting](../features/sorting.md) |
| `searchable()` | Include in global search. See [Searching](../features/searching.md) |
| `toggleable()` | Allow hiding via the column menu. See [Column Visibility](../features/column-visibility.md) |
| `formatStateUsing()` / `formatUsing()` | Transform the displayed value: `fn ($state, $record) => ...` |
| `getStateUsing()` | Compute the value from the record: `fn ($record) => ...` |
| `description()` | Secondary text, `position: 'below'` (default) or `'above'` |
| `tooltip()`, `url()`, `openUrlInNewTab()` | Hover text and links |
| `prefix()`, `suffix()` | Text around the value |
| `alignStart()`, `alignCenter()`, `alignEnd()`, `alignJustify()` | Alignment |
| `width()`, `grow()`, `size()` | Sizing |
| `visible()`, `hidden()` | Show or hide the column |

## Editable columns

`ToggleColumn`, `SelectColumn`, `TextInputColumn`, and `CheckboxColumn` are editable: the user changes the value in the cell and the panel saves it. Both the Vue and React tables render them.

> Inline editing for `SelectColumn`, `TextInputColumn`, and `CheckboxColumn` requires Laravilt v1.1 or later.

Each change is sent to one endpoint, which `laravilt/tables` registers under every panel:

```
PATCH {panel}/_tables/{resource}/{record}/column
```

The request body is `{ "column": "status", "value": "published" }`. The endpoint uses the same middleware as the panel's pages (session, panel auth, localization, and tenant identification), and then:

1. rebuilds the resource's table and finds the column. Plain display columns, disabled columns, and relationship columns (such as `author.name`) are rejected with a 403;
2. loads the record through the resource's `getEloquentQuery()`, so tenant scoping applies;
3. checks the resource's `canUpdate()` (your policy's `update` method, or the panel's permission system). It returns a 403 when the check fails;
4. validates the value against the column's type rules plus its `rules()`;
5. runs `beforeStateUpdated()`, sets only that column's attribute, saves the record, and runs `afterStateUpdated()`.

The update is optimistic. The cell shows the new value straight away, and it goes back to the old value with an error notification if the server rejects the change. A validation error shows the rule's message.

### Limitations

- In relation-manager tables, editable cells are read-only.
- The endpoint is registered only on path-based panel routes. Panels served on tenant subdomains don't get it, so their editable cells are read-only.
- The card-grid layout has no editable `SelectColumn`, `TextInputColumn`, or `CheckboxColumn` cells. They display as text.
