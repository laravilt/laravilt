---
title: Grid
description: Responsive multi-column layout.
order: 2
---

# Grid

A responsive multi-column layout.

## Basic usage

```php
use Laravilt\Forms\Components\TextInput;
use Laravilt\Schemas\Components\Grid;

Grid::make(2)
    ->schema([
        TextInput::make('first_name'),
        TextInput::make('last_name'),
    ]);
```

`make()` accepts a column count, a responsive array or a name. You can also call `columns()`:

```php
Grid::make()->columns(4)->schema([/* ... */]);
```

## Responsive columns

```php
Grid::make([
    'default' => 1, // mobile
    'sm' => 2,      // 640px+
    'md' => 3,      // 768px+
    'lg' => 4,      // 1024px+
])->schema([/* ... */]);
```

Breakpoints follow Tailwind: `sm` 640px, `md` 768px, `lg` 1024px, `xl` 1280px, `2xl` 1536px.

## Column span

```php
Grid::make(3)
    ->schema([
        TextInput::make('title')->columnSpan(2),
        TextInput::make('status'),
        TextInput::make('description')->columnSpanFull(),
    ]);
```

## API reference

| Method | Description |
|--------|-------------|
| `make(string\|int\|array)` | Create with a name or columns |
| `columns(int\|array)` | Column layout |
| `schema(array)` | Child components |
