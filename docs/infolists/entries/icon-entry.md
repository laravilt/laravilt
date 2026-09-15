---
title: IconEntry
description: Lucide icons with boolean mode, dynamic icons and colors.
order: 3
---

# IconEntry

Displays a [Lucide](https://lucide.dev/icons) icon.

```php
use Laravilt\Infolists\Entries\IconEntry;

IconEntry::make('is_verified')->boolean();

IconEntry::make('is_active')
    ->boolean()
    ->trueIcon('CheckCircle')
    ->falseIcon('XCircle')
    ->trueColor('success')
    ->falseColor('danger');

IconEntry::make('status')
    ->icon(fn (string $state): string => match ($state) {
        'pending' => 'Clock',
        'completed' => 'CheckCircle',
        default => 'Circle',
    })
    ->size('lg')
    ->color('primary');
```

## API reference

| Method | Description |
|--------|-------------|
| `icon(string\|Closure)` | Icon name |
| `boolean(?trueIcon, ?falseIcon)` | Boolean mode |
| `trueIcon()` / `falseIcon()` | Boolean icons |
| `trueColor()` / `falseColor()` | Boolean colors |
| `size(string)` | Icon size |
| `circular(bool)` | Circular background |
| `color(string\|Closure)` | Icon color |
