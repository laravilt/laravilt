---
title: RepeatableEntry
description: Display arrays or relationships with nested entries.
order: 8
---

# RepeatableEntry

Displays an array or a relationship. Each item uses a nested entry schema.

```php
use Laravilt\Infolists\Entries\RepeatableEntry;
use Laravilt\Infolists\Entries\TextEntry;

RepeatableEntry::make('order_items')
    ->collapsible()
    ->collapsed()
    ->emptyMessage('No items yet')
    ->schema([
        TextEntry::make('product.name'),
        TextEntry::make('quantity'),
        TextEntry::make('price')->money('USD'),
    ]);
```

## API reference

| Method | Description |
|--------|-------------|
| `schema(array)` | Entries for each item |
| `collapsible(bool)` / `collapsed(bool)` | Collapse items |
| `emptyMessage(string)` | Text when there are no items |
