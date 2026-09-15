---
title: IconColumn
description: Display Lucide icons, optionally mapped from boolean or status values.
order: 3
---

# IconColumn

Icons use [Lucide](https://lucide.dev/icons) names in PascalCase (for example `CheckCircle`).

```php
use Laravilt\Tables\Columns\IconColumn;

IconColumn::make('icon'); // the state is used as the icon name
```

## Boolean mode

```php
IconColumn::make('is_verified')
    ->boolean()
    ->trueIcon('CheckCircle')
    ->falseIcon('XCircle')
    ->trueColor('success')
    ->falseColor('danger');
```

Without custom icons, boolean mode uses `CheckCircle` and `XCircle`. `BooleanColumn` is a shortcut for an `IconColumn` in boolean mode.

## Dynamic icons

Closures can receive `$state` and `$record`:

```php
IconColumn::make('status')
    ->icon(fn (string $state) => match ($state) {
        'active' => 'CheckCircle',
        'pending' => 'Clock',
        default => 'AlertCircle',
    })
    ->color(fn (string $state) => $state === 'active' ? 'success' : 'secondary')
    ->iconSize('lg');
```

## API reference

| Method | Description |
|--------|-------------|
| `icon()` | Icon name or closure |
| `color()` | Icon color or closure |
| `iconSize()` / `size()` | Icon size |
| `boolean()` | Boolean mode |
| `trueIcon()`, `falseIcon()` | Boolean icons |
| `trueColor()`, `falseColor()` | Boolean colors |
| `wrap()` | Wrap multiple icons |
