---
title: SelectColumn
description: Configure a select dropdown for a table column.
order: 6
---

# SelectColumn

```php
use Laravilt\Tables\Columns\SelectColumn;

SelectColumn::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ]);
```

The cell shows a dropdown. Picking an option saves it to the record straight away. See [Editable columns](README.md#editable-columns) for how the save is authorized and validated.

> Inline editing requires Laravilt v1.1 or later.

The value must be one of the option keys. With `selectablePlaceholder()` (the default), the dropdown also has an empty entry, and choosing it stores `null`. Your `rules()` are added after those checks.

## Options

```php
use App\Models\Category;

SelectColumn::make('category_id')
    ->options(fn () => Category::pluck('name', 'id')->all())
    ->optionsSearchable()
    ->selectablePlaceholder(false)
    ->disableOptionWhen(fn ($value) => $value === 'archived');
```

`selectablePlaceholder(false)` removes the empty entry and makes a value required.

> The bundled tables always render a styled dropdown and ignore `native()`. They don't apply `disableOptionWhen()` either, and neither does the update endpoint. To block a value, add a rule, such as `->rules([Rule::notIn(['archived'])])`.

## Hooks and disabling

```php
SelectColumn::make('status')
    ->options([...])
    ->disabled(fn () => ! auth()->user()->isAdmin())
    ->afterStateUpdated(function ($record, string $column, $value) {
        // ...
    });
```

## API reference

| Method | Description |
|--------|-------------|
| `options()` | Array or closure of options |
| `optionsSearchable()` | Searchable options |
| `native()` | Use a native `<select>` (ignored by the bundled tables) |
| `selectablePlaceholder()` | Allow selecting the empty placeholder (stores `null`). Default `true` |
| `disableOptionWhen()` | Disable individual options (not enforced by the bundled tables) |
| `placeholder()` | Label of the empty entry |
| `rules()` | Validation rules, added after the option check |
| `disabled()` | Make the dropdown read-only |
| `beforeStateUpdated()`, `afterStateUpdated()` | Update hooks |
