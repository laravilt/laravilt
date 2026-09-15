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
| [SelectColumn](select-column.md) | Select configuration for a column |
| [TextInputColumn](text-input-column.md) | Text input configuration for a column |
| [CheckboxColumn](checkbox-column.md) | Checkbox configuration for a column |

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
