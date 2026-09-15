---
title: ToggleButtons
description: Button group for selecting one or more options.
order: 6
---

# ToggleButtons

A group of buttons for selecting one or more options.

## Basic usage

```php
use Laravilt\Forms\Components\ToggleButtons;

ToggleButtons::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ]);
```

## Grouped, icons and colors

```php
ToggleButtons::make('view_mode')
    ->options(['grid' => 'Grid', 'list' => 'List'])
    ->icons(['grid' => 'LayoutGrid', 'list' => 'List'])
    ->colors(['grid' => 'primary', 'list' => 'gray'])
    ->grouped();
```

## Multiple selection

```php
ToggleButtons::make('formatting')
    ->options(['bold' => 'B', 'italic' => 'I', 'underline' => 'U'])
    ->multiple()
    ->grouped();
```

## API reference

| Method | Description |
|--------|-------------|
| `options(array\|Closure)` | Set options |
| `multiple(bool)` | Allow several values |
| `grouped(bool)` | Join the buttons into one group |
| `inline(bool)` | Inline layout |
| `icons(array\|Closure)` | Icon per option |
| `colors(array\|Closure)` | Color per option |
