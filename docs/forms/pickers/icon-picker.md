---
title: IconPicker
description: Pick Lucide icons from a searchable grid.
order: 2
---

# IconPicker

Pick an icon from the [Lucide](https://lucide.dev/icons) library. The stored value is the icon name.

## Basic usage

```php
use Laravilt\Forms\Components\IconPicker;

IconPicker::make('icon')
    ->label('Select Icon')
    ->searchable();
```

## Restrict the icon set

```php
IconPicker::make('action_icon')
    ->icons(['Pencil', 'Trash2', 'Eye'])
    ->gridColumns(6)
    ->showIconName();
```

## Multiple icons

```php
IconPicker::make('icons')->multiple()->maxItems(3);
```

## API reference

| Method | Description |
|--------|-------------|
| `icons(array\|Closure)` | Limit the available icons |
| `searchable(bool)` | Search box |
| `gridColumns(int)` | Columns in the grid |
| `showIconName(bool)` | Show names under icons |
| `multiple(bool)` / `minItems()` / `maxItems()` | Multiple icons |
