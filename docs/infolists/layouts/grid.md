---
title: Grid
description: Multi-column layouts for infolist entries.
order: 2
---

# Grid

Arranges entries in responsive columns.

```php
use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Schemas\Components\Grid;

Grid::make(3)
    ->schema([
        TextEntry::make('title'),
        TextEntry::make('status'),
        TextEntry::make('description')->columnSpan(2),
    ]);

Grid::make(['default' => 1, 'sm' => 2, 'lg' => 3])
    ->schema([/* ... */]);
```

See [Grid](../../schemas/components/grid.md) for the full API.
