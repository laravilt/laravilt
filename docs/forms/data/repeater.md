---
title: Repeater
description: Repeating groups of fields with limits, reordering and relationships.
order: 1
---

# Repeater

A repeating group of fields.

## Basic usage

```php
use Laravilt\Forms\Components\Repeater;
use Laravilt\Forms\Components\TextInput;

Repeater::make('contacts')
    ->schema([
        TextInput::make('name')->required(),
        TextInput::make('email')->email(),
    ])
    ->columns(2);
```

## Limits and behaviour

```php
Repeater::make('features')
    ->schema([TextInput::make('name')])
    ->minItems(1)
    ->maxItems(10)
    ->defaultItems(1)
    ->reorderable()
    ->collapsible()
    ->cloneable()
    ->addActionLabel('Add feature')
    ->itemLabel(fn (array $state) => $state['name'] ?? null);
```

## Relationship

```php
Repeater::make('items')
    ->relationship()   // uses the "items" relation
    ->schema([
        TextInput::make('product'),
        TextInput::make('quantity')->numeric(),
    ]);
```

## API reference

| Method | Description |
|--------|-------------|
| `schema(array\|Closure)` | Fields for each item |
| `columns(?int)` | Columns inside each item |
| `minItems(int)` / `maxItems(int)` / `defaultItems(int)` | Item counts |
| `reorderable()` / `collapsible()` / `cloneable()` / `deletable()` | Item actions |
| `addActionLabel(string)` / `deleteButtonLabel(string)` | Button labels |
| `itemLabel(Closure\|string)` | Header label per item |
| `relationship(?string)` | Save to a HasMany relationship |
