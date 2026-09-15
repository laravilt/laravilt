---
title: CheckboxColumn
description: Configure a checkbox for a boolean table column.
order: 8
---

# CheckboxColumn

```php
use Laravilt\Tables\Columns\CheckboxColumn;

CheckboxColumn::make('agreed_to_terms')
    ->label('Terms')
    ->rules(['boolean']);
```

The cell shows a checkbox. Checking or unchecking it saves the new value to the record straight away. See [Editable columns](README.md#editable-columns) for how the save is authorized and validated.

> Inline editing requires Laravilt v1.1 or later.

The value is always validated as `required|boolean`, and your `rules()` are added after that. It's stored as `true` or `false`.

## Hooks and disabling

`beforeStateUpdated()` and `afterStateUpdated()` receive the record, the column name, and the new value:

```php
CheckboxColumn::make('agreed_to_terms')
    ->disabled(fn () => ! auth()->user()->isAdmin())
    ->afterStateUpdated(function ($record, string $column, $value) {
        // ...
    });
```

A disabled checkbox is read-only, and the endpoint rejects updates to it.

## API reference

| Method | Description |
|--------|-------------|
| `beforeStateUpdated()` | Before-update hook |
| `afterStateUpdated()` | After-update hook |
| `rules()` | Validation rules, added after `required` and `boolean` |
| `disabled()` | Make the checkbox read-only |
