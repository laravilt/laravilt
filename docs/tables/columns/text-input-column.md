---
title: TextInputColumn
description: Configure a text input for a table column.
order: 7
---

# TextInputColumn

```php
use Laravilt\Tables\Columns\TextInputColumn;

TextInputColumn::make('title')
    ->placeholder('Enter title...');
```

The cell shows a text input. The value is saved when the user presses Enter or leaves the input, and pressing Escape discards the edit. See [Editable columns](README.md#editable-columns) for how the save is authorized and validated.

> Inline editing requires Laravilt v1.1 or later.

The value is validated as `nullable|string`, or `nullable|numeric` when `type('number')` is set. Your `rules()` are added after those. Clearing the input stores `null`, unless your rules reject an empty value (for example, `required`).

## Input types

```php
TextInputColumn::make('email')->type('email');
TextInputColumn::make('quantity')->type('number');
```

## Affixes

```php
TextInputColumn::make('price')
    ->type('number')
    ->inputPrefix('$')
    ->inputSuffixIcon('DollarSign')
    ->rules(['required', 'numeric', 'min:0']);
```

`inputPrefix()` and `inputSuffix()` appear as text next to the input. The bundled tables don't show the `inputPrefixIcon()` and `inputSuffixIcon()` icons yet.

## Hooks and disabling

```php
TextInputColumn::make('sku')
    ->disabled(fn () => ! auth()->user()->isAdmin())
    ->afterStateUpdated(function ($record, string $column, $value) {
        // ...
    });
```

## API reference

| Method | Description |
|--------|-------------|
| `type()` | HTML input type |
| `inputPrefix()`, `inputSuffix()` | Text shown next to the input |
| `inputPrefixIcon()`, `inputSuffixIcon()` | Icons inside the input (not shown by the bundled tables yet) |
| `inputPrefixIconColor()`, `inputSuffixIconColor()` | Icon colors |
| `placeholder()` | Placeholder text |
| `rules()` | Validation rules, added after the type rules |
| `disabled()` | Make the input read-only |
| `beforeStateUpdated()`, `afterStateUpdated()` | Update hooks |
