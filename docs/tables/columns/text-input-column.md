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

> The bundled Vue and React tables have no dedicated renderer for `TextInputColumn`. It displays with the text renderer, and the panel runs update hooks only for `ToggleColumn`. For inline editing today, use an [action with a form](../../actions/forms.md).

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

## API reference

| Method | Description |
|--------|-------------|
| `type()` | HTML input type |
| `inputPrefix()`, `inputSuffix()` | Text inside the input |
| `inputPrefixIcon()`, `inputSuffixIcon()` | Icons inside the input |
| `inputPrefixIconColor()`, `inputSuffixIconColor()` | Icon colors |
| `rules()` | Validation rules |
| `beforeStateUpdated()`, `afterStateUpdated()` | Update hooks |
